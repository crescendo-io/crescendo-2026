import * as THREE from 'three';
import createColorStudioEnv from './studio-hero-glass/color-studio-env.js';
import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass.js';
import { ShaderPass } from 'three/examples/jsm/postprocessing/ShaderPass.js';
import { UnrealBloomPass } from 'three/examples/jsm/postprocessing/UnrealBloomPass.js';
import { OutputPass } from 'three/examples/jsm/postprocessing/OutputPass.js';
import { FXAAShader } from 'three/examples/jsm/shaders/FXAAShader.js';
import createLivingDroplet from './studio-hero-glass/living-droplet.js';
import { CHROMA_SHADER } from './studio-hero-glass/shaders.js';

function getPixelRatio() {
    return Math.min(window.devicePixelRatio || 1, 2.25);
}

function initStudioHeroSculpture(container) {
    if (!container || container.dataset.studioHeroInit === '1') {
        return true;
    }

    var canvas = container.querySelector('.studio-hero__gl');
    var fallback = container.querySelector('.studio-hero__fallback');
    if (!canvas) {
        return false;
    }

    container.dataset.studioHeroInit = '1';

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isActive = true;
    var pointer = new THREE.Vector2(0, 0);
    var smoothPointer = new THREE.Vector2(0, 0);
    var glassImpulse = 0;
    var idlePhase = 0;

    var scene = new THREE.Scene();
    scene.background = new THREE.Color(0x030405);

    var dropletFocus = new THREE.Vector3(1.15, 0.02, 0);
    var lookTarget = new THREE.Vector3(-0.15, 0, 0);

    var camera = new THREE.PerspectiveCamera(28, 1, 0.1, 50);
    camera.position.set(0, 0.06, 5.05);

    var renderer;
    try {
        renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true,
            alpha: false,
            powerPreference: 'high-performance',
            stencil: false,
        });
        renderer.setPixelRatio(getPixelRatio());
        renderer.outputColorSpace = THREE.SRGBColorSpace;
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.32;
    } catch (err) {
        container.classList.add('is-fallback');
        return false;
    }

    var envMap = createColorStudioEnv(renderer);
    scene.environment = envMap;

    var dropletRig = new THREE.Group();
    dropletRig.position.copy(dropletFocus);
    scene.add(dropletRig);

    var droplet = createLivingDroplet(envMap);
    dropletRig.add(droplet.mesh);

    function innerGlow(hex, x, y, z, scale) {
        var glow = new THREE.Mesh(
            new THREE.SphereGeometry(scale, 20, 16),
            new THREE.MeshBasicMaterial({ color: hex })
        );
        glow.position.set(x, y, z);
        dropletRig.add(glow);
        return glow;
    }

    var innerGlows = [
        innerGlow(0xff4a22, -0.32, 0.22, -0.62, 0.26),
        innerGlow(0xffb020, 0.12, 0.38, -0.58, 0.16),
        innerGlow(0x2f8fff, 0.38, -0.08, -0.55, 0.22),
        innerGlow(0xb05cff, -0.08, -0.28, -0.48, 0.14),
    ];

    function rigLight(color, x, y, z, int) {
        var light = new THREE.PointLight(color, int, 8, 2);
        light.position.set(x, y, z);
        dropletRig.add(light);
        return light;
    }

    rigLight(0xff6030, 0.55, 0.85, 0.75, 22);
    rigLight(0x5aa8ff, -0.65, 0.45, 0.55, 18);
    rigLight(0xffe090, 0.15, 1.1, 0.6, 12);

    var coloredLights = [
        { color: 0xff7845, pos: [-1.2, 4.5, 2.5], int: 10 },
        { color: 0x6eb5ff, pos: [3.2, 3.8, 2], int: 9 },
        { color: 0xffe9a6, pos: [1.8, 5.5, 2.8], int: 7 },
    ];
    coloredLights.forEach(function (cfg) {
        var light = new THREE.PointLight(cfg.color, cfg.int, 20, 2);
        light.position.set(cfg.pos[0], cfg.pos[1], cfg.pos[2]);
        scene.add(light);
    });

    var key = new THREE.DirectionalLight(0xffffff, 1.6);
    key.position.set(2.2, 7.5, 3.8);
    scene.add(key);

    var rim = new THREE.DirectionalLight(0xb8d4ff, 0.35);
    rim.position.set(-1.5, 3.5, -4.2);
    scene.add(rim);

    scene.add(new THREE.AmbientLight(0x404858, 0.06));

    var composer;
    var fxaaPass;
    var chromaPass;

    function setupPost(width, height) {
        var dpr = getPixelRatio();
        composer = new EffectComposer(renderer);
        composer.setPixelRatio(dpr);
        composer.addPass(new RenderPass(scene, camera));
        composer.addPass(new UnrealBloomPass(
            new THREE.Vector2(width * dpr, height * dpr),
            reducedMotion ? 0.1 : 0.2,
            0.48,
            0.88
        ));
        chromaPass = new ShaderPass(CHROMA_SHADER);
        chromaPass.uniforms.bias.value = smoothPointer;
        composer.addPass(chromaPass);
        fxaaPass = new ShaderPass(FXAAShader);
        fxaaPass.material.uniforms.resolution.value.set(1 / (width * dpr), 1 / (height * dpr));
        composer.addPass(fxaaPass);
        composer.addPass(new OutputPass());
    }

    function resize() {
        var rect = container.getBoundingClientRect();
        var width = Math.max(16, Math.round(rect.width || container.clientWidth));
        var height = Math.max(16, Math.round(rect.height || container.clientHeight));
        var dpr = getPixelRatio();

        var aspect = width / height;
        camera.aspect = aspect;
        camera.updateProjectionMatrix();
        dropletFocus.x = aspect > 1.12 ? 1.18 : 0.2;
        lookTarget.x = aspect > 1.12 ? -0.22 : -0.05;
        dropletRig.position.x = dropletFocus.x;
        renderer.setPixelRatio(dpr);
        renderer.setSize(width, height, false);

        if (composer) {
            composer.setPixelRatio(dpr);
            composer.setSize(width, height);
            if (fxaaPass) {
                fxaaPass.material.uniforms.resolution.value.set(1 / (width * dpr), 1 / (height * dpr));
            }
        } else {
            setupPost(width, height);
        }

        return width > 16 && height > 16;
    }

    function uvFromClient(clientX, clientY) {
        var rect = container.getBoundingClientRect();
        var nx = (clientX - rect.left) / rect.width;
        var ny = 1 - (clientY - rect.top) / rect.height;
        return { nx: nx * 2 - 1, ny: ny * 2 - 1 };
    }

    function onPointerMove(e) {
        var p = uvFromClient(e.clientX, e.clientY);
        pointer.set(p.nx, p.ny);
    }

    function onPointerDown() {
        glassImpulse = 1;
    }

    container.addEventListener('pointermove', onPointerMove);
    container.addEventListener('pointerdown', onPointerDown);

    if (typeof ResizeObserver !== 'undefined') {
        new ResizeObserver(function () { resize(); }).observe(container);
    } else {
        window.addEventListener('resize', resize);
    }

    if (typeof IntersectionObserver !== 'undefined') {
        new IntersectionObserver(function (entries) {
            isActive = !!(entries[0] && entries[0].isIntersecting);
        }, { threshold: 0.02, rootMargin: '80px 0px' }).observe(container);
    }

    if (!resize()) {
        container.classList.add('is-fallback');
        return false;
    }

    container.classList.add('is-ready', 'is-glass-lab', 'is-droplet-only');
    if (fallback) {
        fallback.setAttribute('aria-hidden', 'true');
    }

    var last = 0;
    function frame(time) {
        requestAnimationFrame(frame);
        if (document.hidden) {
            last = time;
            return;
        }

        var dt = last > 0 ? Math.min((time - last) / 1000, 0.05) : 0.016;
        last = time;

        var lerp = reducedMotion ? 0.05 : 0.08;
        smoothPointer.x += (pointer.x - smoothPointer.x) * lerp;
        smoothPointer.y += (pointer.y - smoothPointer.y) * lerp;

        idlePhase += dt * (reducedMotion ? 0.3 : 0.85);
        glassImpulse = Math.max(0, glassImpulse - dt * 2.2);

        droplet.morph(idlePhase, glassImpulse, smoothPointer);

        droplet.mesh.position.y = Math.sin(idlePhase * 1.1) * 0.02;
        droplet.mesh.rotation.y = idlePhase * 0.22;
        droplet.mesh.rotation.x = Math.sin(idlePhase * 0.55) * 0.04;
        droplet.mesh.rotation.z = Math.sin(idlePhase * 0.7) * 0.035;

        innerGlows.forEach(function (glow, i) {
            glow.position.y += Math.sin(idlePhase * 1.05 + i) * 0.0006;
        });

        if (chromaPass) {
            chromaPass.uniforms.amount.value = 0.0018
                + Math.sin(idlePhase * 0.5) * 0.00035
                + (Math.abs(smoothPointer.x) + Math.abs(smoothPointer.y)) * 0.0004;
        }

        camera.position.x = smoothPointer.x * 0.05;
        camera.position.y = 0.06 + smoothPointer.y * 0.035;
        camera.position.z = 5.05;
        camera.lookAt(
            lookTarget.x + smoothPointer.x * 0.08,
            lookTarget.y + smoothPointer.y * 0.05,
            0
        );

        if (isActive && composer) {
            composer.render();
        }
    }

    requestAnimationFrame(frame);
    return true;
}

function bootStudioHeroSculpture() {
    var container = document.querySelector('[data-studio-hero-sculpture]');
    if (!container) {
        return;
    }
    var attempts = 0;
    (function tryInit() {
        attempts += 1;
        var rect = container.getBoundingClientRect();
        if (rect.width < 16 || rect.height < 16) {
            if (attempts < 80) {
                requestAnimationFrame(tryInit);
            } else {
                container.classList.add('is-fallback');
            }
            return;
        }
        try {
            initStudioHeroSculpture(container);
        } catch (e) {
            container.classList.add('is-fallback');
        }
    })();
}

window.CrescendoStudioHeroSculpture = { boot: bootStudioHeroSculpture, init: initStudioHeroSculpture };

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootStudioHeroSculpture);
} else {
    bootStudioHeroSculpture();
}