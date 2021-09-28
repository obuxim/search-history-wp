# Search History WP
Search History WP is a small WordPress plugin which creates a database table to store the searched keywords of users along with it's time. Later it exposes an endpoint to retrieve that search history for integration with analytics tool like PowerBI, or even Google Sheets.

## Endpoint Details
The endpoint exposed is straight forward and simple.
```
https://{website.link}/wp-json/zh/v1/search-history
```
Replace the `website.link` with your website. For example: `https://zubairhasan.pro/wp-json/zh/v1/search-history`

## License
[GPL](https://choosealicense.com/licenses/gpl-3.0/)
***
```
NOTE: THE PLUGIN WILL DELETE THE DATABASE TABLE AND SEARCH HISTORIES IT LOGGED WHILE DEACTIVATING
```