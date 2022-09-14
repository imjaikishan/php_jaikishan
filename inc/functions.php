<?php
function getcomic() {
	$head = get_headers('https://c.xkcd.com/random/comic', true);
preg_match('/xkcd.com\/(\d+)/', $head['Location'][0], $matches);
$random =  $matches[1];
	$url = 'https://xkcd.com/' . $random . '/info.0.json';
	$out = file_get_contents( $url );
	$jd = json_decode($out);
	return $jd;
}
function sendComic( $to, $subject, $message, $attachments = array() ) {
	$headers   = array();
	$headers[] = 'Reply-To: Jai Kishan <itsmejaikishan2k@gmail.com>';
	$headers[] = 'X-Mailer: PHP/' . phpversion();

	$headers[] = 'MIME-Version: 1.0';

	if ( ! empty( $attachments )) {
		$boundary  = md5( time() );
		$headers[] = 'Content-type: multipart/mixed;boundary="' . $boundary . '"';
	} else {
		$headers[] = 'Content-type: text/html; charset=UTF-8';
	}
		$output   = array();
		$output[] = '--' . $boundary;
		$output[] = 'Content-type: text/html; charset="utf-8"';
		$output[] = 'Content-Transfer-Encoding: 8bit';
		$output[] = '';
		$output[] = $message;
		$output[] = '';
	foreach ($attachments as $attachment) {
		$output[] = '--' . $boundary;
		$output[] = 'Content-Type: ' . $attachment['type'] . '; name="' . $attachment['name'] . '";';
		if (isset( $attachment['encoding'] )) {
			$output[] = 'Content-Transfer-Encoding: ' . $attachment['encoding'];
		}
		$output[] = 'Content-Disposition: attachment;';
		$output[] = '';
		$output[] = $attachment['data'];
		$output[] = '';
	}
		mail( $to, $subject, implode( "\r\n", $output ), implode( "\r\n", $headers ) );
}
