$(function(){


var container = document.getElementById('container');
var camera = new THREE.PerspectiveCamera(75,window.innerWidth/window.innerHeight,1,10000);
var distance = 1000; 
camera.position.z = distance;

var scene = new THREE.Scene();
scene.add(camera);

renderer = new THREE.CanvasRenderer();
renderer.setSize( window.innerWidth, window.innerHeight );
container.appendChild( renderer.domElement );


camera.lookAt(new THREE.Vector3(0,0,0));

var geometry = new THREE.Geometry();

for ( var i = 0; i < 90; i ++ ) {

	particle = new THREE.Particle( new THREE.ParticleCanvasMaterial( {

		color:  0xffffff, //Math.random() * 0x808080 + 0x808080,
		opacity: 0.025,
		program: function ( context ) {
			/*
			context.beginPath();
			context.arc( 0, 0, 5 , 0, Math.PI * 2, true );
			context.closePath();
			context.fill();
			*/

				// hexagon
		var numberOfSides = 6,
		    size = 10,
		    Xcenter = 0,
		    Ycenter = 0;
		 
		context.beginPath();
		context.moveTo (Xcenter +  size * Math.cos(0), Ycenter +  size *  Math.sin(0));          
		 
		for (var i = 1; i <= numberOfSides;i += 1) {
		context.lineTo (Xcenter + size * Math.cos(i * 2 * Math.PI / numberOfSides), Ycenter + size * Math.sin(i * 2 * Math.PI / numberOfSides));
		}
		context.strokeStyle = "#ffffff";
		context.lineWidth = 0.2;
		context.fill();
		context.stroke();
		}

	} ) );
	particle.position.x = Math.random() * 2000 - 1000;
	particle.position.y = Math.random() * 2000 - 1000;
	particle.position.z = Math.random() * 2000 - 1000;
	particle.scale.x = particle.scale.y = Math.random() * 12 + 5;
	scene.add( particle );

	geometry.vertices.push( new THREE.Vertex( particle.position ) );

}

var line = new THREE.Line( geometry, new THREE.LineBasicMaterial( { color: 0xffffff, opacity: 0.02 } ) );
scene.add( line );

renderer.render( scene, camera );

//document.addEventListener( 'mousemove', onMouseMove, false );
setInterval(changeBackground,10);

function changeBackground(event){
	var timer = new Date().getTime() * 0.0001;
  	camera.position.x = Math.floor(Math.cos( timer ) * 600);
  	camera.position.y = Math.floor(Math.sin( timer ) * 800);
	camera.lookAt(new THREE.Vector3(0,0,0));
	renderer.render( scene, camera );
}

function onMouseMove(event){
	mouseX = (event.clientX - window.innerWidth/2) / window.innerWidth/2;
	mouseY = (event.clientY - window.innerHeight/2) / window.innerHeight/2;
	camera.position.x = Math.sin(mouseX * Math.PI) * distance;
	camera.position.y = - Math.sin(mouseY * Math.PI) * distance;
	camera.lookAt(new THREE.Vector3(0,0,0));
	renderer.render( scene, camera );
}



	
});