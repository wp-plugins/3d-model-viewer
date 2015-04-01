
<div id="stage"></div>

<script>
    stage = document.getElementById("stage");  

	width = <?php echo $width ?>;
	height = <?php echo $height ?>;
	
	var scene = new THREE.Scene();
	var camera = new THREE.PerspectiveCamera( 75, width / height, 0.1, 1000 );
	camera.position.x = <?php echo $camera[0] ?>;
	camera.position.y = <?php echo $camera[1] ?>;
	camera.position.z = <?php echo $camera[2] ?>;
	
	var renderer = new THREE.WebGLRenderer();
	renderer.setSize( width, height );
	renderer.setClearColor( 0x<?php echo $background ?>);
	stage.appendChild( renderer.domElement );	 

	var directionalLight = new THREE.DirectionalLight( 0x<?php echo $directionalColor ?>, 1 );
	directionalLight.position.set( <?php echo $directionalPosition ?> );
	scene.add( directionalLight );
		
	var light = new THREE.AmbientLight( 0x<?php echo $ambient ?> ); // soft white light
	scene.add( light );
	
	controls = new THREE.OrbitControls( camera, stage );
	controls.damping = 0.2;
	controls.addEventListener( 'change', render );

	
	var manager = new THREE.LoadingManager();
	manager.onProgress = function ( item, loaded, total ) {
		console.log( item, loaded, total );
	};
	var onProgress = function ( xhr ) {
		if ( xhr.lengthComputable ) {
			var percentComplete = xhr.loaded / xhr.total * 100;
			console.log( Math.round(percentComplete, 2) + '% downloaded' );
		}
	};
	var onError = function ( xhr ) {
		alert("Fehler");
	};
	var texture = new THREE.Texture();
	  var loader = new THREE.ColladaLoader();
	  loader.options.convertUpAxis = true;
	  loader.load('<?php echo $model ?>', function ( collada ) {
	  var dae = collada.scene;
	  var skin = collada.skins[ 0 ];
	  dae.position.set(<?php echo $modelPosition ?>);//x,z,y- if you think in blender dimensions ;)
	  dae.scale.set(<?php echo $modelScale ?>);

	  scene.add(dae);
	});



	
	
	function render() {
		requestAnimationFrame( render );

		renderer.render( scene, camera );
	}
	render();		
</script>

