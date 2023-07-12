
	<?php
	if(isset($_GET['query'])) {
		$searchTerm = $_GET['query'];

		$searchEngines = array(
			'Google' => 'https://www.google.com/search?q=%s',
			'Bing' => 'https://www.bing.com/search?q=%s',
			'DuckDuckGo' => 'https://duckduckgo.com/html/?q=%s',
			'Yahoo' => 'https://search.yahoo.com/search?p=%s',
			'Ask' => 'https://www.ask.com/web?q=%s'
		);

		$searchResults = array();

		foreach ($searchEngines as $engine => $url) {
			$searchUrl = sprintf($url, urlencode($searchTerm));
			$ch = curl_init($searchUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$html = curl_exec($ch);
			curl_close($ch);
			if (!empty($html)) {
				$searchResults[$engine] = $html;
			}
		}

		if (!empty($searchResults)) {
			echo "<h2>Search Results for '$searchTerm':</h2>";
			$results = array();
			foreach ($searchResults as $engine => $html) {
				$doc = new DOMDocument();
				@$doc->loadHTML($html);
				$xpath = new DOMXPath($doc);
				$links = $xpath->query("//h3/a");
				foreach ($links as $link) {
					$title = $link->nodeValue;
					$url = $link->getAttribute("href");
					if (!empty($title) && !empty($url)) {
						$results[] = array(
							'engine' => $engine,
							'title' => $title,
							'url' => $url
						);
					}
				}
			}
			if (!empty($results)) {
				usort($results, function($a, $b) {
					return strnatcmp($b['title'], $a['title']);
				});
				echo "<ul>";
				foreach ($results as $result) {
					echo "<li><strong>{$result['title']}</strong> - <em>{$result['engine']}</em><br><a href='{$result['url']}'>{$result['url']}</a></li>";
				}
				echo "</ul>";
			} else {
				echo "<h2>No Results Found for '$searchTerm'</h2>";
			}
		}
	}
	?>
