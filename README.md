Joomla! Menu Wrench
==================

Pick and choose any menu item, from any Joomla menu, at any level, and render all of them, and optionally their children, as one menu on the front-end.

**Turns this:**

![Items from three seperate memus](https://raw.github.com/betweenbrain/Image-Attachments/master/three-items-three-menus.png "Items from three seperate memus")

**Into this:**

![Rendered as one menu](https://raw.github.com/betweenbrain/Image-Attachments/master/three-items-three-menus-result.png "Rendered as one menu")

## Other Features ##
- Enables you to selectively render sub-menu items as top-level items.
- Supports view access parameter (ACL)
- Supports menu item manager ordering

## Disclaimer ##
The Joomla Menu Wrench module takes a vastly different approach to rendering menu items. Sometimes, vastly different approaches don't always work, sometimes they do. Sometimes they lead to other ideas. In any case, keep this in mind when experimenting with this module.

## Performance ##
Performance and memory consumption may vary by implementation.

In a test using Joomla 2.5 sample data, rendering all levels of:

**Both the Main and About Joomla menus**

Menu Wrench

- Application 0.116 seconds (+0.004); 13.96 MB (+0.299) - beforeRenderModule mod_menuwrench (Menu Wrench)
- Application 0.148 seconds (+0.033); 14.37 MB (+0.407) - afterRenderModule mod_menuwrench (Menu Wrench)
- Memory Usage: 14.45 MB (15,148,576 Bytes)

Core Menu Module

- Application 0.117 seconds (+0.004); 13.97 MB (+0.302) - beforeRenderModule mod_menu (Main Menu)
- Application 0.132 seconds (+0.014); 14.34 MB (+0.368) - afterRenderModule mod_menu (Main Menu)
- Application 0.132 seconds (+0.000); 14.32 MB (-0.011) - beforeRenderModule mod_menu (About Joomla)
- Application 0.193 seconds (+0.061); 14.67 MB (+0.341) - afterRenderModule mod_menu (About Joomla)
- Memory Usage: 14.71 MB (15,427,464 Bytes)

**Only the Main menu**

Menu Wrench

- Application 0.109 seconds (+0.004); 13.96 MB (+0.298) - beforeRenderModule mod_menuwrench
- Application 0.121 seconds (+0.012); 14.27 MB (+0.305) - afterRenderModule mod_menuwrench
- Memory Usage: 14.31 MB (15,002,584 Bytes)

Core Menu Module

- Application 0.121 seconds (+0.004); 13.96 MB (+0.299) - beforeRenderModule mod_menu
- Application 0.135 seconds (+0.015); 14.33 MB (+0.368) - afterRenderModule mod_menu
- Memory Usage: 14.36 MB (15,056,744 Bytes)

** 1,000 test menu items**

Menu Wrench

- Application 0.148 seconds (+0.005); 18.76 MB (+0.546) - beforeRenderModule mod_menuwrench
- Application 0.255 seconds (+0.107); 19.54 MB (+0.779) - afterRenderModule mod_menuwrench
- Application 0.263 seconds (+0.009); 19.14 MB (-0.399) - afterRender
- Memory Usage: 19.16 MB (20,091,568 Bytes)

Core Menu Module
- Application 0.145 seconds (+0.005); 18.51 MB (+0.290) - beforeRenderModule mod_menu
- Application 0.480 seconds (+0.335); 19.68 MB (+1.172) - afterRenderModule mod_menu
- Application 0.499 seconds (+0.006); 19.72 MB (+0.045) - afterRender
- Memory Usage: 19.72 MB (20,682,064 Bytes)

## Known Issues ##
- Link Type Options (Joomla 2.5): Not supported.


Stable Master Branch Policy
====================
The master branch will, at all times, remain stable. Development for new features will occur in branches, and when ready, will be merged into the master branch.

In the event features have already been merged for the next release series, and an issue arises that warrants a fix on the current release series, the developer will create a branch based off the tag created from the previous release, make the necessary changes, package a new release, and tag the new release. If necessary, the commits made in the temporary branch will be merged into master.

Branch Schema
==============
Shocking as it may seem, my goal is to also support Joomla 1.5. Therefore, the following branch schema will be followed:
* __master__: stable at all times, containing the latest tagged release for Joomla 2.5+.
* __develop__: the latest version in development for Joomla 2.5+. This is the branch to base all pull requests for Joomla 2.5+ on.
* __1.5-master__: stable at all times, containing the latest tagged release for Joomla 1.5.
* __1.5-develop__: the latest version in development for Joomla 1.5. This is the branch to base all pull requests for Joomla 1.5 on.


Contributing
====================
Your contributions are more than welcome! Please make all pull requests against the appropriate [develop](https://github.com/betweenbrain/Menu-Wrench/tree/develop) branch for Joomla version 2.5+ and [1.5-develop](https://github.com/betweenbrain/Joomla-Ajax-Interface/tree/1.5-develop) for Joomla version 1.5.

