import * as THREE from 'three';

function smoothNoise(x, y, z) {
    return (
        Math.sin(x * 1.35 + y * 1.65) * Math.cos(z * 1.45 - x * 0.95)
        + Math.sin(x * 2.4 + z * 1.8) * 0.28
        + Math.cos(y * 1.9 - z * 1.1) * 0.18
    );
}

export default function createLivingDroplet(envMap) {
    var radius = 0.52;
    var geo = new THREE.SphereGeometry(radius, 64, 64);
    geo.computeTangents();
    var base = geo.attributes.position.array.slice();

    var mat = new THREE.MeshPhysicalMaterial({
        color: 0xffffff,
        metalness: 0,
        roughness: 0.035,
        transmission: 0.96,
        thickness: 1.15,
        ior: 1.5,
        dispersion: 2.8,
        iridescence: 0.92,
        iridescenceIOR: 1.3,
        iridescenceThicknessRange: [100, 520],
        attenuationColor: new THREE.Color(0xffe0d0),
        attenuationDistance: 4.2,
        clearcoat: 1,
        clearcoatRoughness: 0.025,
        specularIntensity: 1.45,
        specularColor: new THREE.Color(0xffffff),
        envMap: envMap || null,
        envMapIntensity: 3.4,
        transparent: true,
    });

    var mesh = new THREE.Mesh(geo, mat);

    function morph(time, impulse, pointer) {
        var pos = geo.attributes.position;
        var nudge = pointer ? (pointer.x + pointer.y) * 0.004 : 0;
        var morphStrength = 0.014 + impulse * 0.022 + Math.abs(nudge) * 0.006;

        for (var i = 0; i < pos.count; i++) {
            var bx = base[i * 3];
            var by = base[i * 3 + 1];
            var bz = base[i * 3 + 2];
            var len = Math.sqrt(bx * bx + by * by + bz * bz) || 1;
            var nx = bx / len;
            var ny = by / len;
            var nz = bz / len;

            var teardrop = 1 + Math.max(0, ny) * 0.1 - Math.max(0, -ny) * 0.05;
            var wobble = smoothNoise(
                nx * 2.1 + time * 0.95,
                ny * 2.0 - time * 0.82,
                nz * 1.95 + time * 0.68
            );
            var breathe = 1 + Math.sin(time * 1.1) * 0.012;
            var shell = teardrop * breathe + wobble * morphStrength;
            shell = Math.max(0.72, Math.min(1.18, shell));
            var r = radius * shell;

            pos.setXYZ(i, nx * r, ny * r, nz * r);
        }
        pos.needsUpdate = true;
        geo.computeVertexNormals();
    }

    return { mesh: mesh, morph: morph, material: mat };
}