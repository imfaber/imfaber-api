#!/usr/bin/env bash

if [ -z ${PROJECT} ]; then
  PROJECT="atollo"
fi

PROJECTROOT="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"
DRUPALROOT="$PROJECTROOT/web"
CODER="$PROJECTROOT/vendor/drupal/coder"
PHPCS="$PROJECTROOT/vendor/bin/phpcs"
PHPCBF="$PROJECTROOT/vendor/bin/phpcbf"

if [ -z ${DIR} ]; then
  DIR="$DRUPALROOT/modules/custom"
fi

if [ -d "$CODER" ]; then
  echo "Drupal coder directory exists."
else
  echo "Install Coder module at $CODER"
#  exit
fi

if [ -f ${PHPCS} ]; then
  echo "PHP Code Sniffer exists."
else
  echo "PHPCS not found at $PHPCS. Install squizlabs/php_codesniffer with Composer."
  exit
fi

DRUPALCS=$(${PHPCS} -i | grep Drupal)
if [[ ${DRUPALCS} ]]; then
  echo "Drupal standards installed"
else
  echo "Installing Drupal standards"
  ${PHPCS} --config-set installed_paths ${CODER}/coder_sniffer
fi

echo "Running PHP Code Sniffer with Drupal standard in ${DIR}"
${PHPCS} --standard=Drupal --exclude=Drupal.InfoFiles.AutoAddedKeys,Generic.CodeAnalysis.UselessOverridingMethod ${DIR} --ignore=*.md,

echo "Running PHP Code Sniffer with DrupalPractice standard in ${DIR}"
${PHPCS} --standard=DrupalPractice --exclude=DrupalPractice.Yaml.RoutingAccess ${DIR} --ignore=*.md

if [[ $1 == "-f" ]]; then
  if [ -f ${PHPCS} ]; then
    echo "PHPCBF exists."
  else
    echo "PHPCBF not found at $PHPCBF"
    exit
  fi
  echo "Attempting to automatically fix what we can..."
  ${PHPCBF} --standard=Drupal ${DIR} --ignore=*.md
  ${PHPCBF} --standard=DrupalPractice ${DIR} --ignore=*.md
else
  echo "Run with -f to autofix using phpcbf"
fi

