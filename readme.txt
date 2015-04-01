=== 3D Model Viewer ===
Contributors: joergviola
Donate link: http://www.joergviola.de
Tags: 3d, webgl, threejs
Requires at least: 4.0.0
Tested up to: 4.1.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily display your 3D-models. Upload to media gallery, add shortcode - ready!

== Description ==

This plugin allows you to show your 3D models easily in your wordpress blog.

Simply upload the model and all files references (eg. textures) to the wordpress media gallery, 
add a shortcode to the page where the model should be shown and there you go. 

Currently, Collada DAE files are supported.
Please file a request for other required file formats.

The 3D stage is highly configurable: Define background, ambient or directional light 
as well as the cameras and your models position and scale.

== Installation ==

Install this plugin from the wordpress plugin directory as usual and activate it.
Add the shortcode [3D], wherever you want your model to appear.
Here are the arguments to this short code:

* model: name of the model file in the media gallery. Mandatory. 
* width, height: Size of the 3d stage. Optional, default is 500x300.
* background: Background color. Optional, default is "ffffff".
* ambient: Color of ambient light. Optional, default is "404040".
* directional: Direction and color of directional light source. Optional, default is "1,1,1:ffffff"
* model-position: Point of origin of the model. Optional, default is "0,0,0".
* model-scale: Scale of the model. Optional, default is "1,1,1".

Example:

[3D width="600" height="400" background="436523" model="dummy1.dae" camera="50,50,300" model-position="2,2,2" model-scale="2,2,2" ambient="BBBBBB" directional="1,1,0:FFFF44"]



== Frequently Asked Questions ==

None yet.

== Screenshots ==

1. The plugin in action

== Changelog ==

= 1.0.0 =
First version of the 3D plugin.
Supports DAE files and extensive configuration of the stage.
