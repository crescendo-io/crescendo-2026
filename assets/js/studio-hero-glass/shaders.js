import * as THREE from 'three';

export const WATER_SIM_VERTEX = `
varying vec2 vUv;
void main() {
  vUv = uv;
  gl_Position = vec4(position.xy, 0.0, 1.0);
}
`;

export const WATER_SIM_FRAGMENT = `
precision mediump float;
uniform sampler2D uPrevious;
uniform vec2 uDelta;
uniform vec2 uImpulse;
uniform float uImpulseRadius;
uniform float uImpulseStrength;
uniform float uDamping;
varying vec2 vUv;

void main() {
  vec4 data = texture2D(uPrevious, vUv);
  float height = (data.r - 0.5) * 2.0;
  float velocity = (data.g - 0.5) * 2.0;

  float hL = (texture2D(uPrevious, vUv - vec2(uDelta.x, 0.0)).r - 0.5) * 2.0;
  float hR = (texture2D(uPrevious, vUv + vec2(uDelta.x, 0.0)).r - 0.5) * 2.0;
  float hD = (texture2D(uPrevious, vUv - vec2(0.0, uDelta.y)).r - 0.5) * 2.0;
  float hU = (texture2D(uPrevious, vUv + vec2(0.0, uDelta.y)).r - 0.5) * 2.0;
  float laplacian = (hL + hR + hD + hU) * 0.25 - height;
  velocity += laplacian * 1.65;
  velocity *= uDamping;
  height += velocity;

  float d = distance(vUv, uImpulse);
  if (uImpulseStrength > 0.0 && d < uImpulseRadius) {
    height += (1.0 - smoothstep(0.0, uImpulseRadius, d)) * uImpulseStrength;
  }

  gl_FragColor = vec4(height * 0.5 + 0.5, velocity * 0.5 + 0.5, 0.0, 1.0);
}
`;

export const WATER_SURFACE_VERTEX = `
uniform sampler2D uHeight;
uniform float uSize;
varying vec2 vUv;
varying vec3 vWorldPos;
varying vec3 vNormal;

void main() {
  vUv = uv;
  vec3 pos = position;
  float h = (texture2D(uHeight, uv).r - 0.5) * 2.0;
  float hL = (texture2D(uHeight, uv - vec2(1.0 / uSize, 0.0)).r - 0.5) * 2.0;
  float hR = (texture2D(uHeight, uv + vec2(1.0 / uSize, 0.0)).r - 0.5) * 2.0;
  float hD = (texture2D(uHeight, uv - vec2(0.0, 1.0 / uSize)).r - 0.5) * 2.0;
  float hU = (texture2D(uHeight, uv + vec2(0.0, 1.0 / uSize)).r - 0.5) * 2.0;
  vec3 n = normalize(vec3(hL - hR, 2.2, hD - hU));
  pos.y += h * 0.055;
  vec4 world = modelMatrix * vec4(pos, 1.0);
  vWorldPos = world.xyz;
  vNormal = normalize(mat3(modelMatrix) * n);
  gl_Position = projectionMatrix * viewMatrix * world;
}
`;

export const WATER_SURFACE_FRAGMENT = `
precision mediump float;
uniform vec3 uFloorColor;
uniform vec3 uHighlight;
varying vec3 vWorldPos;
varying vec3 vNormal;

void main() {
  vec3 viewDir = normalize(cameraPosition - vWorldPos);
  vec3 n = normalize(vNormal);
  float fresnel = pow(1.0 - max(dot(viewDir, n), 0.0), 4.5);
  vec3 lightDir = normalize(vec3(0.25, 1.0, 0.42));
  float spec = pow(max(dot(reflect(-lightDir, n), viewDir), 0.0), 160.0);
  vec3 col = mix(uFloorColor, uHighlight, fresnel * 0.06);
  col += vec3(1.0) * spec * 0.35;
  gl_FragColor = vec4(col, 1.0);
}
`;

export const CHROMA_SHADER = {
    uniforms: {
        tDiffuse: { value: null },
        amount: { value: 0.0018 },
        bias: { value: new THREE.Vector2(0, 0) },
    },
    vertexShader: `
        varying vec2 vUv;
        void main() {
            vUv = uv;
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }
    `,
    fragmentShader: `
        uniform sampler2D tDiffuse;
        uniform float amount;
        uniform vec2 bias;
        varying vec2 vUv;
        void main() {
            vec2 c = vUv - 0.5 + bias * 0.15;
            vec2 dir = normalize(c + vec2(0.0001)) * amount * 24.0;
            float r = texture2D(tDiffuse, vUv + dir * 0.85).r;
            float g = texture2D(tDiffuse, vUv).g;
            float b = texture2D(tDiffuse, vUv - dir * 0.72).b;
            gl_FragColor = vec4(r, g, b, 1.0);
        }
    `,
};