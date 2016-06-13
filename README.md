# blank-social


INTRODUCTION
------------

A simple, no-frills MVC approach to simplifying/normalizing the process of displaying a social networking feed on your website or app. It also provides a simple caching mechanism for your feed results to limit traffic to 3rd parties.


### Supported Social: 

- Facebook page feeds
- Twitter user feeds
- Instagram user feeds


### Supported Languages: 

- PHP
- [more to come]


### This is a good fit for you if: 

- You're frustrated with all the variation in social API services; you want a normalized solution
- You want a solution that's simple, without any force-fed CSS or bells and whistles; you just want simple information (HTML or JSON) that you can style yourself
- You want a lightweight solution; you want to limit traffic to 3rd parties by caching your social results


INSTALLATION
------------

1. Download/extract where desired (e.g. http://[YOUR DOMAIN].com/blank-social)
2. Rename '/custom/config_default.php' to '/custom/config.php'
3. Replace '[YOUR APP ID]' (etc.) with your social-specific app settings. Note that you can omit settings for feeds you're not using.


USAGE
-----

### Live examples: 

Twitter user: 
http://blank-social.spaced-man.com/twitter/user/?theme=true

Instagram user: 
http://blank-social.spaced-man.com/instagram/user/?theme=true

Facebook page: 
http://blank-social.spaced-man.com/facebook/page/?theme=false&offset=2&limit=50


### Query options: 

- *theme*: If 'true' or '1', will return themed HTML (which can be customized —  see 'Creating custom templates' for details). Omitting this or setting it to 'false'/'0' will return JSON representing the social results.
- *offset*: An integer —  returns all results from the nth item (NOTE: by default, items are ordered by post date, decreasing)
- *limit*: An integer —  limit the result provided (NOTE: this is different than the 'social_cache_limit' variable in 'config.php', which defines the maximum number of entries stored in the cache)


### Javascript AJAX examples: 

[TO DO]


### Creating custom templates: 

If you'd like to customize the HTML result (for the 'theme' query option), you can do so by copying the '.tpl.php' file into the '/custom' directory. The template file is located in the appropriate social feed directory (e.g. '/facebook/page/facebook-page.tpl.php'). Just copy it over and mess around with file as desired.


TROUBLESHOOTING
---------------

[N/A —  To add as needed]


FAQ
---

Q: Have you finished writing a FAQ?

A: I haven't, sorry. Please come back later.


TO DO
-----

- Add more social services (facebook user feeds, etc.)
- Add more control over query options (e.g. user IDs as options w/ generated JSON files for each requested ID)
- Integration w/ other languages


MAINTAINERS
-----------

Current maintainers:
 * Tyler Shingleton (SPACED-MAN) - http://spaced-man.com
