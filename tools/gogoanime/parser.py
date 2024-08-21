import requests
from bs4 import BeautifulSoup
from rich.console import Console
from rich.status import Status
from pymongo import MongoClient

console = Console()

console.log("connecting to database")
client = MongoClient("mongodb://localhost:27017")
database = client.get_database("cretoo")
collection = database.get_collection("gogoanime")
console.log("connected to cretoo database")

baseDomain = "https://ww8.gogoanimes.org"

results = []
faileds = []

def parse_detail(url, name: str):
    console.log("Anime title: {name}".format(name=name))

    response = requests.get(url=url)
    soup = BeautifulSoup(response.text, features="html.parser")
    animeBodyElement = soup.find("div", {"class": "anime_info_body"})
    
    # Parse semua data
    data  = {}
    image = animeBodyElement.find("img", {"loading": "lazy"})
    title = animeBodyElement.find("h1")
    
    data['title'] = title.text
    data['image'] = image.get("src")

    collection.insert_one(data)

def parse_listing(url, status: Status, page: int):
    response = requests.get(url=url)
    soup = BeautifulSoup(response.text, features="html.parser")
    listingElement = soup.find("ul", {"class": "listing"})
    listings = listingElement.findAll("li")
    for l in listings:
        listing: BeautifulSoup = l
        aLink = listing.find("a")
        link = aLink.get("href")
        try:
            parse_detail(baseDomain + link, aLink.text)
            results.append(link)
        except:
            faileds.append(link)
        status.update("Parsed data {total} page {page} failed {failed}".format(total=len(results), page=page, failed=len(faileds)))
base_url = "https://ww8.gogoanimes.org/anime-list?page={page}"
with console.status("Parsed data {total} page {page} failed {failed}".format(total=0, page=0, failed=0)) as status:
    for i in range(5, 99):
        url = base_url.format(page=i)
        parse_listing(url=url, status=status, page=i)