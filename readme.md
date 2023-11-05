# Automated Mini Blog

## Table of Contents

- [Description](#description)
- [Usage](#usage)
- [Methods](#methods)
- [Parameters](#parameters)
- [Dependencies](#dependencies)
- [Notes](#notes)
- [License](#license)

---

## Description

The automatedMiniBlog class is a PHP implementation designed for automated news processing and summarization. It allows you to fetch news articles from an RSS feed, summarize the titles and articles, and store the information in a database. This class utilizes cURL for HTTP requests and integrates with external APIs for text summarization. Requirements

PHP 7.0 or higher
cURL extension enabled

---

## Usage

    <?php
    
    // Include the class file
    include('automatedMiniBlog.php');
    
    // Create an instance of the automatedMiniBlog class
    $update = new automatedMiniBlog;
    
    // Fetch news from the specified RSS feed URL and process it
    $update->getNews('https://www.newsbtc.com/feed/');
    
    ?>

---

## Methods

    getNews($rss, $limit=5)

This method fetches news articles from the provided RSS feed URL and processes them. It summarizes the titles and articles and checks for duplicates in the database. If a news article is not a duplicate, it can be added to the database (the database functionality is commented out and needs to be implemented).

---

## Parameters:

    $rss (string): URL of the RSS feed from which news articles will be fetched.
    $limit (int, optional): Number of news articles to fetch and process. Default is 5.

---

## Dependencies

This class relies on external APIs for text summarization. Please make sure you have the necessary API keys and permissions to use the following services:

**RapidAPI Service 1**

    Base URL: https://chatgpt-api8.p.rapidapi.com
    Endpoint: /summarize
    Headers: X-RapidAPI-Host: chatgpt-api8.p.rapidapi.com, X-RapidAPI-Key: YOUR_API_KEY_IN_RAPIDAPI.COM

**RapidAPI Service 2**

    Base URL: https://article-extractor-and-summarizer.p.rapidapi.com
    Endpoint: /summarize
    Headers: X-RapidAPI-Host: article-extractor-and-summarizer.p.rapidapi.com, X-RapidAPI-Key: YOUR_API_KEY_IN_RAPIDAPI.COM

---

## Notes

**API Keys**
Ensure that you have valid API keys for the external services used in this class. Replace YOUR_API_KEY_IN_RAPIDAPI.COM with your actual API keys in the code.

**Database Integration**
Database functionality (checking for duplicates and adding new articles) is outlined in the comments and needs to be implemented according to your database structure.

**Error Handling**
Error handling for cURL requests is included in the class. Ensure proper error handling and logging in a production environment.

---

## License

This class is provided under the MIT License. See the LICENSE file for details.
