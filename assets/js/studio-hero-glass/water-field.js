import * as THREE from 'three';
import { WATER_SIM_VERTEX, WATER_SIM_FRAGMENT } from './shaders.js';

export default class WaterField {
    constructor(renderer, size) {
        this.renderer = renderer;
        this.size = size || 256;
        this.impulse = new THREE.Vector2(0.5, 0.5);
        this.impulseStrength = 0;
        this.impulseRadius = 0.08;
        this.damping = 0.985;

        var opts = {
            minFilter: THREE.LinearFilter,
            magFilter: THREE.LinearFilter,
            format: THREE.RGBAFormat,
            type: THREE.UnsignedByteType,
            depthBuffer: false,
            stencilBuffer: false,
        };

        this.targets = [
            new THREE.WebGLRenderTarget(this.size, this.size, opts),
            new THREE.WebGLRenderTarget(this.size, this.size, opts),
        ];
        this.index = 0;

        this.scene = new THREE.Scene();
        this.camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
        this.uniforms = {
            uPrevious: { value: this.targets[0].texture },
            uDelta: { value: new THREE.Vector2(1 / this.size, 1 / this.size) },
            uImpulse: { value: this.impulse.clone() },
            uImpulseRadius: { value: this.impulseRadius },
            uImpulseStrength: { value: 0 },
            uDamping: { value: this.damping },
        };
        this.quad = new THREE.Mesh(
            new THREE.PlaneGeometry(2, 2),
            new THREE.ShaderMaterial({
                uniforms: this.uniforms,
                vertexShader: WATER_SIM_VERTEX,
                fragmentShader: WATER_SIM_FRAGMENT,
            })
        );
        this.scene.add(this.quad);

        renderer.setRenderTarget(this.targets[0]);
        renderer.setClearColor(0x000000, 0);
        renderer.clear();
        renderer.setRenderTarget(this.targets[1]);
        renderer.clear();
        renderer.setRenderTarget(null);
    }

    addDrop(uvX, uvY, strength) {
        this.impulse.set(uvX, uvY);
        this.impulseStrength = Math.max(this.impulseStrength, strength);
        this.uniforms.uImpulse.value.copy(this.impulse);
        this.uniforms.uImpulseStrength.value = this.impulseStrength;
    }

    step() {
        var src = this.targets[this.index];
        var dst = this.targets[1 - this.index];
        this.uniforms.uPrevious.value = src.texture;
        this.uniforms.uImpulseStrength.value = this.impulseStrength;
        this.impulseStrength = 0;

        this.renderer.setRenderTarget(dst);
        this.renderer.render(this.scene, this.camera);
        this.renderer.setRenderTarget(null);
        this.index = 1 - this.index;
    }

    getTexture() {
        return this.targets[this.index].texture;
    }
}