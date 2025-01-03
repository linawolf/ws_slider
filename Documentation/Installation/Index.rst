.. include:: ../Includes.txt

.. _installation:

============
Installation
============

.. contents:: Table of Contents

.. _installation-composer:

Installation Composer
=====================

Install extension :composer:`wapplersystems/ws-slider` via Composer:

.. code-block:: bash

   composer req wapplersystems/ws-slider

.. _installation-classic:

Installation Classic mode
=========================

- Login to the backend of TYPO3 as a user with Administrator privileges

- Download and install the extension :t3ext:`ws_slider` by the **Extension Manager**

.. _configuration:

Configuration
=============

In TYPO3 13 we recommend that you include the settings of this extension via
`Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_.

You only have to include the set of your choice, it handles all dependencies
itself.

.. _configuration-site-sets:

Configuration with Site Sets (preferred)
----------------------------------------

This extension ships, at the time of writing, 4 different Slider Renderer.
Include the set of the Slider Renderer of you choice in the site configuration
of your site or depend on it in your site package.

.. figure:: /Images/SiteSets.png
   :alt: Screenshot of the Site Settings in the TYPO3 Backend, demonstrating choosing WS Slider FlexSlider set for this site.

   Chooser the slider type of your choice. If you do not want to supply the
   assets yourself chose the version including the assets.

Each site set comes in a version that includes the assets for the slider
(JavaScript, Css) and a plain version without.

To add a slider type to your
`site packages set <https://docs.typo3.org/permalink/t3sitepackage:minimal-extension-siteset>`_,
add it as a dependency as follows:

.. code-block:: diff
   :caption: packages/my_site_package/Configuration/Sets/SitePackage/config.yaml

    name: my-vendor/my-site-package
    label: 'My Site Package'
    dependencies:
      - typo3/fluid-styled-content
   +  - wapplersystems/ws-slider-flexslider-assets

The following sets are available:

`wapplersystems/ws-slider`
   General Slider, if you use this you have to provide a custom rendering including
   the desired assets.
`wapplersystems/ws-slider-flexslider`, `wapplersystems/ws-slider-flexslider-assets`
   FlexSlider `<https://github.com/woocommerce/FlexSlider/wiki/FlexSlider-Properties>`_
`wapplersystems/ws-slider-owl`, `wapplersystems/ws-slider-flexslider-owl`
   Owl `<https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html>`_
`wapplersystems/ws-slider-slick`, `wapplersystems/ws-slider-slick-assets`
   Slick `<https://kenwheeler.github.io/slick/>`_
`wapplersystems/ws-slider-tiny-slider`, `wapplersystems/ws-slider-tiny-slider-assets`
   TinySlider `<https://ganlanyuan.github.io/tiny-slider/#options>`_

.. _configuration-typoscript-records:

Configuration with TypoScript Records
-------------------------------------

To enable the sliders for editors, you have to add them to the page properties in the TSconfig settings. You can decide which slider or layout you want to add. To do this:

1. Go to `List` in your TYPO3 Backend's side menu.
2. Select `YOUR PAGE` in the page hierarchy.
3. Select the `edit page properties` button at the top.
4. Navigate to the `Resources` tab and add the items for the sliders you need in the `Page TSconfig` section as shown in the image below.


.. image:: ../Images/TSconfigIncludes.png

Add the template of the extension to your main template by:

1. Going to `List` in your TYPO3 Backend's side menu.
2. Select `YOUR PAGE` in the page hierarchy.
3. Add a new template called `+ext` with the top plus symbol.
4. Edit the template.
5. Go the `Includes` tab and add the items for the sliders you need ad shown in the image below.


.. image:: ../Images/TemplateIncludes.png

.. _adding-content:

Adding Content
==============

Select which slider you want to use and add slider elements. In each slider element you can set an image source.

.. image:: ../Images/Elements.png

.. _slider-settings:

Slider Settings
===============

Within the `Settings` tab when editing your content element you can find settings for the specific slider you have selected.
Here is an example for the Owl slider. Each setting has a default value, if you want to change a setting you can select the checkbox and set the specific value.

.. image:: ../Images/OwlSettings.png

These settings are built after the respective endpoints the sliders offer.
The respective Documentation that we used can be found here:

* Owl `<https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html>`_
* FlexSlider `<https://github.com/woocommerce/FlexSlider/wiki/FlexSlider-Properties>`_
* TinySlider `<https://ganlanyuan.github.io/tiny-slider/#options>`_
* Slick `<https://kenwheeler.github.io/slick/>`_
