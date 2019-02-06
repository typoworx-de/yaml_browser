# TYPO3 Extension "yaml_browser"
Browse and debug YAML definitions in TYPO3 in a way similar to the "TypoScript Object Browser".

## What does it do?

Since version 8.x, TYPO3 increasingly uses YAML configuration files for configuring specific parts of the CMS. 
Currently, inside the core, YAML files ares used for the forms extension, Site configurations and configuring the ckeditor.


In some cases, for instance with the form definitions, the YAML configuration can become a bit overwhelming -
several extensions which add their own configurations, one configuration overriding the other, etc - and you might want 
to double check, what the YAML configuration, that TYPO3 internally parses, now looks like.


That's where this YAML Browser module comes in. It behaves similar to the TypoScript Object Browser inside TYPO3 Core,
which, well, does exactly the same with TypoScript. 


You can look up the YAML in a tree view, do a quick search for a text string and can even run a regex against it.

![Yaml Browser](/Resources/Public/Screenshots/yaml_browser.png)

## Requirements

Currently supports TYPO3 9.5 LTS.

## 1. Installation

### Installation with composer

`composer require christianessl/yaml_browser`. 

### Installation with TER

Open the TYPO3 Extension Manager, search for `yaml_browser` and install the extension.

## 2. Usage

Clear caches and reload the backend for all changes to take effect. 
You can now find the YAML browser module in the Admin Tools panel. (Administrator permissions required)