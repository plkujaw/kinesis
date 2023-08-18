# WordPress Technical Test
##### by Kuba Jawor

## Task description
The goal of the test was to build WordPress website based on provided design. The site content and layout should be flexible. The data displayed should be provided by external API.

## Approach
To deliver required flexibility for content and layout, plugin ACF PRO was used. This allowed to use custom Gutenberg Blocks and Repeater Field for extended flexibility. 

As the data provider, CoinMarketCap API was used. The graph data is randomly generated dummy data.

Last Price value is stored in cookies on the time of fetching data (for 1 hour). Next time when the data is fetched (API updates data every 1 minute), the previous price stored in cookies is compared to the currently fetched price and changes the colour accordingly. Then the current price is being stored as the previous price in cookies and the cycle repeats every time the new data is fetched (so if the site refreshed in less than 1 minute interval, the price won't change). The value used for comparison is after rounding (so the displayed one) otherwise it would very rarely stay the same (raw value has format 26436.264454322234 so any small change would be picked up).

To generate graphs, Chart.js library was used. The data provided is a randomly generated dummy data ('price' from last 'x' amount of days).

## Known bugs, issues and improvement prospects
Because of the setup of used starter theme, the editor and blocks styles and scripts are not separated. Instead (as a workaround), to enable front-end styles in the editor, the main css stylesheet was enqueued to the editor. This causes obvious performance drawbacks but also in some places overrides default WP UI styling. This could have been prevented by different bundling/enqueueing strategy. As for the scripts, they are not currently working in the back-end (again, that could have been fixed by different setup).

Also because of the used starter theme, there are some unused files present and some WP functionalities are disabled (no posts, no comments etc.)

For displaying ACF fields data, more 'defensive' approach should have been used to prevent errors or any spacing issues in case of certain fields has not been filled.

For the API key, secure way should have been used to store it.

The table could have been more responsive. :)

In the design, the Lato font in weight 500 was used but this weight is actually not provided for this font so even though it is declared in CSS to use `font-weight: 500;` it renders 400.

## How to use it
1. Clone the repository directly into `wp-content/themes` folder (it is essentially a `kinesis` theme).
2. Install ACF PRO plugin in minimum version 6.0 (6.2.0 was used; if required, I can provide it) and sync any Field Groups available to sync.
3. Install SVG SUPPORT plugin (this is really only to enable adding svg files into content, if PNG or any other files will be used, this is not necessary).
4. Build the content with provided blocks.

No other plugins were used.

## For development
1. After cloning, run `npm install` in the theme's root folder.
2. To start development mode, run `npm run dev`.
3. For development mode with browserSync, use `npm run dev-sync` (note: it is setup so it proxies `https://${package.name}.local` [LocalWP was used for development] where `package.name` is declared in `package.json` so this must be adjusted to the dev's setup).
4. Run `npm run build` for production-ready bundling.
