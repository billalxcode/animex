import os
import json
import time
import requests
from rich.console import Console
from rich.progress import track
from slugify import slugify

console = Console()

# Here we define our query as a multi-line string
query = "query($season:MediaSeason,$seasonYear:Int $nextSeason:MediaSeason,$nextYear:Int){trending:Page(page:1,perPage:6){media(sort:TRENDING_DESC,type:ANIME,isAdult:false){...media}}season:Page(page:1,perPage:6){media(season:$season,seasonYear:$seasonYear,sort:POPULARITY_DESC,type:ANIME,isAdult:false){...media}}nextSeason:Page(page:1,perPage:6){media(season:$nextSeason,seasonYear:$nextYear,sort:POPULARITY_DESC,type:ANIME,isAdult:false){...media}}popular:Page(page:1,perPage:6){media(sort:POPULARITY_DESC,type:ANIME,isAdult:false){...media}}top:Page(page:1,perPage:10){media(sort:SCORE_DESC,type:ANIME,isAdult:false){...media}}}fragment media on Media{id title{userPreferred}coverImage{extraLarge large color}startDate{year month day}endDate{year month day}bannerImage season seasonYear description type format status(version:2)episodes duration chapters volumes genres isAdult averageScore popularity mediaListEntry{id status}nextAiringEpisode{airingAt timeUntilAiring episode}studios(isMain:true){edges{isMain node{id name}}}}"

# Define our query variables and values that will be used in the query request
variables = {"type": "ANIME", "season": "SUMMER",
             "seasonYear": 2024, "nextSeason": "FALL", "nextYear": 2024}


url = 'https://graphql.anilist.co'

console.log("Getting response graphql")
# Make the HTTP Api request
response = requests.post(url, json={'query': query, 'variables': variables})
response_json = json.loads(response.text)
data = response_json['data']

console.log("Getting trending data")
trending = data['trending']['media']

for media in track(trending, description="Downloading data"):
    user_prefered = media['title']['userPreferred']
    cover = media['coverImage']['large']
    data = requests.get(cover)
    slug = slugify(user_prefered) + ".jpg"
    path = os.path.join(
        os.getcwd(),
        "..",
        "assets",
        "image",
        "animes",
        slug
    )
    with open(path, "wb") as File:
        File.write(data.content)
        File.close()
    