# DeepAI-API-Drupal-Module
Drupal Module for Node Generation with the [DeepAI Text Generation API](https://deepai.org/machine-learning-model/text-generator)

---

Author: **David Archuleta Jr.** <darchuletajr@gmail.com>

This module attempts to request the DeepAI Text-Generator API and create Article nodes with their body fields full of AI generated text. The module implements a DeepAI Service wrapper for the Guzzle Client. It also has an admin settings form for the api-key and the 'base string', and a 'generate node form' for actually generating the nodes.

TODO:
* it would be nice to be able to choose which content type we generate but I'll hardcode Article for now.
* it would also be great to define a new Plugin Type for this module, where we could choose and save different 'generate' plugins.
* Need to rework the actual request because the text generation takes forever.
* If you try this out, make sure to validate your email with the api or it will deny you (you need to register to get your api key).
* Write tests
