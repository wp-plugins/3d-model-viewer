

function WP3D(model, options) {

	this.init = function(model, options) {
	    stage = document.getElementById(options.id);  
	
	    width = 0;
	    pWidth = options.width;
	    if (pWidth.indexOf('%')==pWidth.length-1) {
	        width = stage.offsetWidth * parseInt(pWidth) / 100;
	    } else {
	        width = parseInt(pWidth);
	    }
	
	    height = 0;
	    pHeight = options.height;
	    if (pHeight.indexOf('%')==pHeight.length-1) {
	    	height = stage.offsetHeight * parseInt(pHeight) / 100;
	    } else {
	    	height = parseInt(pHeight);
	    }
	    
	    this.scene = new THREE.Scene();
	    this.camera = new THREE.PerspectiveCamera( 75, width / height, 0.1, 1000 );
	    this.camera.position.x = options.camera[0];
	    this.camera.position.y = options.camera[1];
	    this.camera.position.z = options.camera[2];
		
		this.renderer = new THREE.WebGLRenderer({ alpha: true });
		this.renderer.setSize( width, height );
		this.renderer.setClearColor( options.background, options.opacity);
		stage.appendChild( this.renderer.domElement );	 
	
		var directionalLight = new THREE.DirectionalLight( options.directionalColor, 1 );
		directionalLight.position.set( options.directionalPosition[0], options.directionalPosition[1], options.directionalPosition[2] );
		this.scene.add( directionalLight );
			
		var light = new THREE.AmbientLight( options.ambient ); // soft white light
		this.scene.add( light );
		
		controls = new THREE.OrbitControls( this.camera, stage );
		controls.damping = 0.2;
		controls.addEventListener( 'change', setDirty );
		
		console.log(model);
		
		if (this.endsWith(model, '.dae'))
			this.loadDAE(model, options);
		else if (this.endsWith(model, '.obj'))
			this.loadOBJ(model, options);
		
		dirty = true;
	}

	this.endsWith = function(str, suffix) {
	    return str.toLowerCase().indexOf(suffix.toLowerCase(), str.length - suffix.length) !== -1;
	}
	
	this.loadDAE = function(model, options) {
		var loader = new THREE.ColladaLoader();
		loader.options.convertUpAxis = true;
		var loadScene = this.scene;
		loader.load(model, function ( collada ) {
		  var dae = collada.scene;
		  var skin = collada.skins[ 0 ];
		  dae.position.set(options.modelPosition[0],options.modelPosition[1],options.modelPosition[2]);//x,z,y- if you think in blender dimensions ;)
		  dae.scale.set(options.modelScale[0],options.modelScale[1],options.modelScale[2]);
	
		  loadScene.add(dae);
		});
	}

	this.loadOBJ = function(model, options) {
		console.log('loading OBJ');
		var loader = new THREE.OBJMTLLoader();
		mtl = model.substring(0, model.length-3) + 'mtl';
		var loadScene = this.scene;
		loader.load( model, mtl, function ( object ) {
			object.position.set(options.modelPosition[0],options.modelPosition[1],options.modelPosition[2]);//x,z,y- if you think in blender dimensions ;)
			object.scale.set(options.modelScale[0],options.modelScale[1],options.modelScale[2]);
			loadScene.add( object );
		});
	}
	
	
	this.init(model, options);
	
	this.render = function() {
    	this.renderer.render( this.scene, this.camera );
	}
	
}

lastRendered = Date.now();
dirty = true;

function setDirty() {
	dirty = true;
}


function render() {
	requestAnimationFrame( render );

    delta = Date.now() - lastRendered;
    if (dirty && delta > 1000/options.fps) {
    	lastRendered = Date.now();
    	wp3d.render();
    	dirty = false;
    }
	
}
