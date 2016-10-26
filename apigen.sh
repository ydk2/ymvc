#!/bin/sh
alias apigen="php ~/bin/apidoc/apigen.phar"
apigen generate --source ./ --destination ./docs  --annotation-groups=ymvc --title="YMVC System" --access-levels="public","protected","private"
