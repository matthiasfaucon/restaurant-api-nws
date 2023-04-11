import json
import os
from selenium.webdriver.support import expected_conditions as EC
from selenium import webdriver
from selenium.webdriver.common.by import By
import time
from selenium.webdriver.support.ui import WebDriverWait


# créer une instance du navigateur
driver = webdriver.Firefox()

# ouvrir la page web
driver.get('https://www.allrecipes.com/ingredients-a-z-6740416')

# attendre que la page se charge complètement
time.sleep(2)

# extraire les éléments <a> qui contiennent les liens des ingrédients
ingredients = driver.find_elements(By.CLASS_NAME, 'link-list__link')
recipes_object = []
recipes_list = []
recipes_images = []
recipes_href = []

ingredient_names = []
ingredient_infos = []
ingredients_href =  []
ingredient_recipes_links = []

for ingredient in ingredients:
    ingredient_names.append(ingredient.text)
    ingredients_href.append(ingredient.get_attribute('href'))

for id_ingredient, ingredient_link in enumerate(ingredients_href):
    if id_ingredient < 2:
        recipes_href_this_ingredient = []
        recipes_images_this_ingredient = []
        driver.get(ingredient_link)
        time.sleep(1)
        recipes_images = driver.find_elements(By.CLASS_NAME, 'card__img')
        recipes_links = driver.find_elements(By.CLASS_NAME, 'mntl-card-list-items')
        for recipe_link, recipe_image in zip(recipes_links, recipes_images):
            output = recipe_link.get_attribute('href') in recipes_href
            outputImg = recipe_image.get_attribute('src') in recipes_images
            recipes_href.append(recipe_link.get_attribute('href'))
            if recipe_image.get_attribute('src'):
                recipes_images.append(recipe_image.get_attribute('src'))
            elif recipe_image.get_attribute('data-src'):
                recipe_image.get_attribute('data-src')
            if output == False:
                recipes_href_this_ingredient.append(recipe_link.get_attribute('href'))
                recipes_href.append(recipe_link.get_attribute('href'))
                if recipe_image.get_attribute('src'):
                    recipes_images_this_ingredient.append(recipe_image.get_attribute('src'))
                elif recipe_image.get_attribute('data-src'):
                    recipes_images_this_ingredient.append(recipe_image.get_attribute('data-src'))

        for href, image in zip(recipes_href_this_ingredient, recipes_images_this_ingredient):
            driver.get(href)
            isRecipe = driver.find_elements(By.CLASS_NAME, 'article-subheading')
            if isRecipe:
                titre_recette = driver.find_elements(By.CLASS_NAME, 'article-heading')[0].text
                # print(recipes_object)
                recette_check = next(filter(lambda x: titre_recette in x['titre'], recipes_object), None)
                if recette_check is None:
                    oneRecipe = {
                        'titre': titre_recette,
                        'image': image,
                        'ingredient' : [ingredient_names[id_ingredient]],
                        'description': driver.find_elements(By.CLASS_NAME, 'article-subheading')[0].text
                    }
                    recipes_object.append(oneRecipe)
                else :
                    if ingredient_names[id_ingredient] not in recette_check['ingredient']:
                        recette_check['ingredient'].append(ingredient_names[id_ingredient])

        driver.get('https://www.allrecipes.com/ingredients-a-z-6740416')
        array_list = {
            'ingredients': ingredient_names,
            'recipes': recipes_object
        }

# Ouvrez un fichier en mode écriture
if (not os.path.exists("scrapper-datas")):
    os.mkdir("scrapper-datas")

fichier_json = open('scrapper-datas/datas.json', 'w')

# Écrivez la liste d'objets dans le fichier JSON
json.dump(array_list, fichier_json)

# # Fermez le fichier
fichier_json.close()

driver.quit()
