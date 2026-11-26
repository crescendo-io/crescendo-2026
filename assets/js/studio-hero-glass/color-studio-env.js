import * as THREE from 'three';

/**
 * PMREM coloré (orange / ambre / bleu / violet) pour reflets type « glass lab ».
 */
export default function createColorStudioEnv(renderer) {
    var envScene = new THREE.Scene();
    envScene.background = new THREE.Color(0x020304);

    function addGlow(hex, x, y, z, radius) {
        var sphere = new THREE.Mesh(
            new THREE.SphereGeometry(radius, 20, 16),
            new THREE.MeshBasicMaterial({ color: hex })
        );
        sphere.position.set(x, y, z);
        envScene.add(sphere);

        var disc = new THREE.Mesh(
            new THREE.CircleGeometry(radius * 2.2, 24),
            new THREE.MeshBasicMaterial({ color: hex, side: THREE.DoubleSide })
        );
        disc.position.set(x, y, z);
        disc.lookAt(0, 0, 0);
        envScene.add(disc);
    }

    addGlow(0xff5c28, -6, 2.2, -1, 1.55);
    addGlow(0xffc030, -2, 4.5, 2.5, 1.05);
    addGlow(0xffe880, 1.5, 5.2, 0.5, 0.65);
    addGlow(0x3d8fff, 6, 1.8, 1.2, 1.35);
    addGlow(0x7a5cff, 3.2, 0.2, 3.5, 0.85);
    addGlow(0xc94bff, -3.5, -0.5, 4, 0.55);
    addGlow(0xffffff, 0.5, 7, -0.5, 0.4);

    var pmrem = new THREE.PMREMGenerator(renderer);
    pmrem.compileEquirectangularShader();
    var texture = pmrem.fromScene(envScene, 0.028).texture;
    pmrem.dispose();
    return texture;
}