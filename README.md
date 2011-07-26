Demonoid RSS Torrent Downloader
===============================

## README ##

This script gets a user's RSS feed from [demonoid][1] and changes the links to point to the actual torrent file instead of just the torrent page.

It does this by changing the link to point to this script which will login to demonoid and get the torrent file.

## Pre-Setup ##

First things first, you must have a demonoid account for this to work.
Your server will need to have PHP >= 5.2.1, cURL, and DOMDocument to use this script.

## Setup ##

To use this script, place it on your webserver somewhere.  Then in the same folder create a file called `demonoidPW.php` and place the following in that file:

    <?php
      $postInfo = array(
        'nickname' => 'Demonoid Username',
        'password' => 'Demonoid Password'
      );
    ?>

## Downloading Torrents ##

Normally, a user's RSS feed is `http://www.demonoid.me/rss/users/USERNAME.xml`.  Instead of using that URL, use `http://YOURSERVER/path/to/demonoid.php/USERNAME`.  The links in the returned RSS will be changed from the torrent page (`http://www.demonoid.me/files/details/xxx/yyy`) to this script (`http://YOURSERVER/path/to/demonoid.php/xxx/yyy`).  These links will be direct links to the torrent files (the PHP script will login to demonoid, and stream the torrent file).

  [1]: http://demonoid.me