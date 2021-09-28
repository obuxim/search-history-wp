# Search History WP
Search History WP is a small WordPress plugin which creates a database table to store the searched keywords of users along with it's time. Later it exposes an endpoint to retrieve that search history for integration with analytics tool like PowerBI, or even Google Sheets.

## Endpoint Details
The endpoint exposed is straight forward and simple.
```
https://{website.link}/wp-json/zh/v1/search-history
```
Replace the `website.link` with your website. For example: `https://zubairhasan.pro/wp-json/zh/v1/search-history`

## License
[GPL](https://www.gnu.org/licenses/gpl-2.0.html)

## Upcoming Features:
- View search keywords and volumes in a table.
- Alert before deactivation of the plugin.
- Export to CSV
***
```
NOTE: THE PLUGIN WILL DELETE THE DATABASE TABLE AND SEARCH HISTORIES IT LOGGED WHILE DEACTIVATING
```