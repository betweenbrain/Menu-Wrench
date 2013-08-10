Joomla! Menu Wrench
==================
Throw a wrench at your Joomla menus!

Turns this:

![Items from three seperate memus](https://raw.github.com/betweenbrain/Image-Attachments/master/three-items-three-menus.png "Items from three seperate memus")

Into this:

![Rendered as one menu](https://raw.github.com/betweenbrain/Image-Attachments/master/three-items-three-menus-result.png "Rendered as one menu")

## Features ##
- Supports view access parameter (ACL)
- Supports menu item manager ordering

## Performance ##
Performance and memory consumption may vary by implementation.

In a test using Joomla 2.5 sample data, rendering all levels of:

###  Both the Main and About Joomla menus ###

#### Menu Wrench ####

- Application 0.116 seconds (+0.004); 13.96 MB (+0.299) - beforeRenderModule mod_menuwrench (Menu Wrench)
- Application 0.148 seconds (+0.033); 14.37 MB (+0.407) - afterRenderModule mod_menuwrench (Menu Wrench)
- Memory Usage: 14.45 MB (15,148,576 Bytes)

#### Core Menu Module ####

- Application 0.117 seconds (+0.004); 13.97 MB (+0.302) - beforeRenderModule mod_menu (Main Menu)
- Application 0.132 seconds (+0.014); 14.34 MB (+0.368) - afterRenderModule mod_menu (Main Menu)
- Application 0.132 seconds (+0.000); 14.32 MB (-0.011) - beforeRenderModule mod_menu (About Joomla)
- Application 0.193 seconds (+0.061); 14.67 MB (+0.341) - afterRenderModule mod_menu (About Joomla)
- Memory Usage: 14.71 MB (15,427,464 Bytes)

### Only the Main menu ###

#### Menu Wrench ####
- Application 0.109 seconds (+0.004); 13.96 MB (+0.298) - beforeRenderModule mod_menuwrench (Menu Wrench)
- Application 0.121 seconds (+0.012); 14.27 MB (+0.305) - afterRenderModule mod_menuwrench (Menu Wrench)
- Memory Usage: 14.31 MB (15,002,584 Bytes)

#### Core Menu Module ####
- Application 0.121 seconds (+0.004); 13.96 MB (+0.299) - beforeRenderModule mod_menu (Main Menu)
- Application 0.135 seconds (+0.015); 14.33 MB (+0.368) - afterRenderModule mod_menu (Main Menu)
- Memory Usage: 14.36 MB (15,056,744 Bytes)

## Known Issues ##
- Target Window: Not yet supported.
- Link Type Options (Joomla 2.5): Not yet supported.
