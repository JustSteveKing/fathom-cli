# Fathom CLI

An opinionated CLI for working with the usefathom API.

## Installation

Fathom CLi can easily be installed using composer, the easiest way is to install this globally as a composer dependency:

```bash
composer global require juststeveking/fathom-cli
```

You are now ready to check your site stats or set up a local project with a `fathom.yml` file.

## Usage

### Setting up globally

To set the Fathom CLI up globally, you need to have an API key ready, then run:

```bash
fathom setup
```

This will ask you for your fathom API token, which will be stored `~/.fathom/config.php`


### Setting up locally in a project

To set up a project locally first you need to have a `fathom.yml` file in the root of your project directory. The init command will link the current working directory with a site on Fathom.

When calling `fathom init`, you can choose from an interactive list, which site you want to link the project to.

// add image here

After selecting the site, you can now go ahead and call the site commands. You are able to safely store this configuration file in version control to sync later on if need be. It will only contain a working path to you project locally and the site ID from fathom. The API token never leaves your local file system.

