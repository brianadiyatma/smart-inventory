Command line instructions
You can also upload existing files from your computer using the instructions below.

Git global setup
git config --global user.name "Moyasin"
git config --global user.email "yasin.dobhe@gmail.com"

Create a new repository
git clone git@gitlab.com:mochamadyasin/inka-smart-inventory-mobile.git
cd inka-smart-inventory-mobile
git switch -c main
touch README.md
git add README.md
git commit -m "add README"
git push -u origin main

Push an existing folder
cd existing_folder
git init --initial-branch=main
git remote add origin git@gitlab.com:mochamadyasin/inka-smart-inventory-mobile.git
git add .
git commit -m "Initial commit"
git push -u origin main

Push an existing Git repository
cd existing_repo
git remote rename origin old-origin
git remote add origin git@gitlab.com:mochamadyasin/inka-smart-inventory-mobile.git
git push -u origin --all
git push -u origin --tags

