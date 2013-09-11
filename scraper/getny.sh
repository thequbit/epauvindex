#!/bin/bash

# make sure we have our bash env setup correct
export WORKON_HOME=/home/administrator/.virtualenvs
source /etc/bash_completion.d/virtualenvwrapper

# enter virt env
workon epa

# run our script
cd /home/administrator/dev/epauvindex/scraper && python getny.py

# leave virt env
deactivate

