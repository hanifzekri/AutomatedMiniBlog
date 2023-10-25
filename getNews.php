<?php

class auotmatedMiniBlog {
	
	//-------------
	private function curl($host, $value, $method) {
		
		$context = array(
		CURLOPT_URL => 'https://' . $host . (($method == 'get')?$value:''),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => strtoupper($method),
		);
		
		$headval = array('X-RapidAPI-Host: ' . $host, 'X-RapidAPI-Key: YOUR_API_KEY_IN_RAPIDAPI.COM');
		if ($method == 'post') {
			array_push($headval, 'content-type: application/json');
			$context[CURLOPT_POSTFIELDS] = json_encode([['content' => $value, 'role' => 'user']]);
		}
		
		$context[CURLOPT_HTTPHEADER] = $headval;
		
		$curl = curl_init();
		curl_setopt_array($curl, $context);
		$response = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);
		
		$result = array();
		if ($error) {
			$result['status'] = false;
			$result['response'] = $error;
		} else {
			$result['status'] = true;
			$result['response'] = $response;
		}

		return $result;
	}
	
	//------------
	public function getNews($rss, $limit=5) {
		
		$counter = 0;
		$xml = simplexml_load_file($rss);
		$xml = $xml->channel;
		foreach($xml->item as $list) {
			
			$counter++;
			if ($counter >= $limit) break;
			
			$ns_data = $list->children("http://search.yahoo.com/mrss/");
			$ns_data = $ns_data->attributes();

			$main_title = $list->title; //record this to check for duplicate news
			$image = $ns_data['url'];

			$value = 'summerize this title with warm tone: ' . urlencode($main_title);
			$result = $this->curl('chatgpt-api8.p.rapidapi.com', $value, 'post');

			if ($result['status'] == false) echo 'EROOR: '. $result['response'];
			else {
				$result = json_decode($result['response'], true);
				$new_title = $result['text'];
			}

			//summerize article
			$url = $list->link;
			$value = '/summarize?length=5&url=' . urlencode($url);
			$result = $this->curl('article-extractor-and-summarizer.p.rapidapi.com', $value, 'get');

			if ($result['status'] == false) echo 'EROOR: '. $result['response'];
			else {
				$result = json_decode($result['response'], true);
				$description = str_replace("\\n", "<br>", $result['summary']);
			}

			$duplicate = false;
			/*
				check db for duplicate entry by title
				$check = $db->prepare('SELECT count(*) as duplicate_count FROM `blog` WHERE article_title = ?');
				$check->bind_param('s', $main_title);
				$check->execute();
				$result = $check->get_result();
				if ($result->duplicate_count > 0) $duplicate = true;

			*/

			if ($duplicate == false){

				/*

					add new article to DB
					$main_title
					$new_title
					$url
					$desc
					$image

				*/
			}
		}
	}
}

//
$update = new auotmatedMiniBlog;
$update->getNews('https://www.newsbtc.com/feed/');

?>