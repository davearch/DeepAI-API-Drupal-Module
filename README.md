# DeepAI-API-Drupal-Module
Drupal Module for Node Generation with the [DeepAI Text Generation API](https://deepai.org/machine-learning-model/text-generator)

---

Author: **David Archuleta Jr.** <darchuletajr@gmail.com>

So I made a DeepAI Client Service that uses the Guzzle http module (now in Core) to send the requests.
I also made a Simple Configuration Object for the Module Administration Settings.

TODO:
* Make another Form for actually creating the node objects under either the content or structure administrative menus.
* it would be nice to be able to choose which content type we generate but I'll hardcode Article for now.
* it would also be great to define a new Plugin Type for this module, where we could choose and save different 'generate' plugins.
