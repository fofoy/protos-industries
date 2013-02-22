$(function(){
/* 1. SCENE */
var $container = $('#organ_3d');
	var WIDTH = 600,
	    HEIGHT = 500;
	var VIEW_ANGLE = 45,
	    ASPECT = WIDTH / HEIGHT;
var scene = new THREE.Scene();


/* 2. CAMERA */

var camera = new THREE.PerspectiveCamera(VIEW_ANGLE, ASPECT, 0.1, 1000);
camera.position.set(0,0,5);


/* 3. OBJECTS */

var loader = new THREE.ColladaLoader();
loader.options.convertUpAxis = true;
loader.load( 'public/models/brain.dae', function (model) {
	var piano = model.scene;
	//piano.scale.set(0.2,0.2,0.2);
	piano.position.set(30,30,-100);
	piano.rotation.set(Math.PI/8,Math.PI/4,0);
	scene.add(piano);
});

/* 4. LIGHTS */

var directionalLight = new THREE.DirectionalLight(0xFFFFFF, 1); 
	directionalLight.position.set(-5,1,10); 
scene.add(directionalLight);


/* 5. RENDERER */

var renderer = new THREE.WebGLRenderer({antialias:true});
renderer.setSize(WIDTH, HEIGHT);
$container.append(renderer.domElement);


function render() { 
	requestAnimationFrame(render);
	if(rotate){
		var timer = Date.now() * 0.0015;
		camera.position.x  = Math.cos(timer) * 65;
		camera.position.z  = Math.sin(timer) * 65;
	}
	camera.lookAt(scene.position); 
	renderer.render(scene, camera); 
} 

render();




/* CONTROL */

var rotate = false;

/*
document.addEventListener('mousemove', function(e){
	var mouseX = e.clientX - window.innerWidth/2;
	camera.position.set(mouseX/10, 0, 15);
})
*/



});