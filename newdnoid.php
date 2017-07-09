<?php 
	if(empty($_SERVER["PATH_INFO"])) exit;
	$get = explode('/', trim($_SERVER["PATH_INFO"],'/'));
	$dem = simplexml_load_file("http://www.demonoid.pw/rss/users/{$get[0]}.xml");
	
	// create rss document with root element
	$ed = new DOMDocument('1.0', "UTF-8");
	$rssElement = $ed->createElement('rss');
	$rssAttribute = $ed->createAttribute('version');
	$rssAttribute->value = '2.0';
	$rssElement->appendChild($rssAttribute);
	$ed->appendChild($rssElement);
	
	// get feed title and description
	$feedtitle = $dem->title[0];
	$feedsubtitle = $dem->subtitle[0];
	
	// create channel element in rss document root element
	$rssChannel = $ed->createElement('channel');
	$rssElement->appendChild($rssChannel);
	
	// create channel child elements and populate with values
	$rssChannelTitle = $ed->createElement('title', $feedtitle);
	$rssChannel->appendChild($rssChannelTitle);
	
	$rssChannelLink = $ed->createElement('link', 'http://demonoid.pw/');
	$rssChannel->appendChild($rssChannelLink);
	
	$rssChannelLanguage = $ed->createElement('language', 'en-us');
	$rssChannel->appendChild($rssChannelLanguage);
	
	$rssChannelDescription = $ed->createElement('description', $feedtitle);
	$rssChannel->appendChild($rssChannelDescription);
	
	foreach($dem->children() as $entry) {
		
		$i++;
		
		if($i > 8) {
			
			// create item element in channel element
			$rssChannelItem = $ed->createElement('item');
			$rssChannel->appendChild($rssChannelItem);
			
			// create item child elements and populate with values
			$itemtitle = $entry->title;
			$rssChannelItemTitle = $ed->createElement('title', $itemtitle);
			$rssChannelItem->appendChild($rssChannelItemTitle);
			
			$itemlink = $entry->link['href'];
			$rssChannelItemLink = $ed->createElement('link', $itemlink);
			$rssChannelItem->appendChild($rssChannelItemLink);
			
			$entryupdated = $entry->updated;
			$entryupdatedstring = strtotime($entryupdated);
			$itempubdate = gmstrftime('%a, %d %b %Y %T %Z', $entryupdatedstring);
			$rssChannelItemPubdate = $ed->createElement('pubDate', $itempubdate);
			$rssChannelItem->appendChild($rssChannelItemPubdate);
			
			$entrylinkhreffull = $entry->link['href'];
			$entrylinkhreftrim = explode('/', rtrim($entrylinkhreffull, '/'));
			$entrylinkhreflength = count($entrylinkhreftrim);
			$entrylinkhrefnumber = $entrylinkhreftrim[$entrylinkhreflength-1];
			$itemenclosureurl = "https://demonoid.pw/files/download/$entrylinkhrefnumber/";
			$itemenclosuretype = "application/x-bittorrent";
			$rssChannelItemEnclosure = $ed->createElement('enclosure');
			$rssChannelItemEnclosureURL = $ed->createAttribute('url');
			$rssChannelItemEnclosureURL->value = $itemenclosureurl;
			$rssChannelItemEnclosure->appendChild($rssChannelItemEnclosureURL);
			$rssChannelItemEnclosureType = $ed->createAttribute('type');
			$rssChannelItemEnclosureType->value = $itemenclosuretype;
			$rssChannelItemEnclosure->appendChild($rssChannelItemEnclosureType);
			$rssChannelItem->appendChild($rssChannelItemEnclosure);
			
		}
			
	}
 	
	die($ed->SaveXML());
	
?>
