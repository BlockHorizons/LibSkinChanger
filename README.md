# LibSkinChanger
-----
A library for PocketMine-MP to easily manipulate Player skins and geometry.<br>
[![Chat](https://img.shields.io/badge/chat-on%20discord-7289da.svg)](https://discord.gg/YynM57V) 

### How do I use this?
LibSkinChanger is a so called virion. It gets injected in your plugin's Poggit phar build automatically if you configure your poggit.yml file correctly, so you don't have to do anything! Alternatively you could of course include this as a sub module or simply clone the repository in yours.
<br>

_But how do I do that?_
<br><br>

Step 1. Enable Poggit-CI on your builds at [The Poggit Website](https://poggit.pmmp.io/ci).<br>
Step 2. Navigate to the poggit.yml file in your project, it should look something like this:
```yaml
--- # Poggit-CI Manifest. Open the CI at https://poggit.pmmp.io/ci/Author/PluginName
branches:
- master
projects:
  YourPlugin:
    path: ""
...
```
Step 3. Add the library to your poggit.yml file. It should look like this now:
```yaml
--- # Poggit-CI Manifest. Open the CI at https://poggit.pmmp.io/ci/Author/PluginName
branches:
- master
projects:
  YourPlugin:
    path: ""
    libs:
      - src: BlockHorizons/LibSkinChanger/LibSkinChanger
        version: ^1.0.0
...
```
Step 4. Push a commit to your repository to make Poggit build, and the library will be integrated in your plugin.

### Where can I find the API?
The API of this library is scattered through a couple files. All API functions contain documentation which should make the functionality very clear.
Due to potentially time consuming operations, it is recommended to make geometry and skin modifications in an async task, as seen in the test plugin.

API Files:
- /PlayerSkin.php
- /SkinPixel.php
- /SkinGeometry.php
- /SkinComponents/SkinComponent.php
- /SkinComponents/Geometry.php
- /SkinComponents/Cube.php

Example files:
- /Tests/SkinChanger.php
- /Tests/SkinChangeTask.php
- /Tests/HumanExplodeTask.php
- /Tests/HumanRebuildTask.php

<br><br>
##### Additional help can always be requested in the issue tracker. Don't hesitate to ask.
##### If you find a feature not working, or would like a new feature to be added. Please do so in the issue tracker, or contact us on Discord. (see above)