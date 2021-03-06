$(function(){

$.getJSON(location.href, function(response){

var rotate = true;

	/* 1. SCENE */
var $container = $('#organ_3d');
	var WIDTH = 600,
	    HEIGHT = 500;
	var VIEW_ANGLE = 75,
	    ASPECT = WIDTH / HEIGHT;
var scene = new THREE.Scene();


/* 2. CAMERA */

var camera = new THREE.PerspectiveCamera(VIEW_ANGLE, ASPECT, 0.1, 1000);
camera.position.set(0,0,-12);
controls = new THREE.TrackballControls( camera );

controls.rotateSpeed = 3.0;
controls.zoomSpeed = 0.2;
controls.panSpeed = 0.8;
controls.noZoom = false;
controls.noPan = false;
controls.staticMoving = true;
controls.dynamicDampingFactor = 0.3;
controls.keys = [ 65, 83, 68 ];

/* 3. OBJECTS */
var organ;
var loader = new THREE.ColladaLoader();
loader.options.convertUpAxis = true;
loader.load( response.organ.model, function (model) {
	organ = model.scene;
	//organ.scale.set(0.2,0.2,0.2);
	organ.position.set(0,0,0);
	organ.rotation.set(Math.PI/8,Math.PI/4,0);
	scene.add(organ);
});

/* 4. LIGHTS */

var directionalLight = new THREE.DirectionalLight(0xFFFFFF, 1); 
	directionalLight.position.set(-5,1,-10); 
scene.add(directionalLight);
var directionalLight2 = new THREE.DirectionalLight(0xFFFFFF, 1); 
	directionalLight2.position.set(5,-1,10); 
scene.add(directionalLight2);


/* 5. RENDERER */

var renderer = new THREE.WebGLRenderer({antialias:true});
renderer.setSize(WIDTH, HEIGHT);
$container.append(renderer.domElement);



$("#rotate_control").click(function(){
	if (rotate==true){
		rotate = false;
	} else {
		if (rotate==false){
			rotate = true;
		}
	}
	console.log(rotate);
});

function animate() {
	render();
	requestAnimationFrame( animate );
	controls.update();
	if (rotate == true){
		rotateOrgan();
	}
}
function rotateOrgan(){
	organ.rotation.y+= 0.004;
}
function render() {
	renderer.render( scene, camera );
}

animate();

});

});