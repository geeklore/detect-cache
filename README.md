# Detect Cache

A plugin created for the PHP class at the Automattic Grand Meetup 2017.

Plugin checks for caching in three ways.
1. Plugin checks the site's HTTP headers for caching directives, load balancers, proxies and proxy services like CloudFlare.
2. Plugin also checks active plugins for any that have the word cache in them.
3. Plugin checks the `/wp-content/` directory for directories with the name cache in it.

If you want the pretty styles for the Admin page, install `detect-cache-admin.css` in your theme's root folder.

![Detect-Cache](http://cld.wthms.co/5E5qjG)
