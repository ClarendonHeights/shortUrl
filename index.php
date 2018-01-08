<!DOCTYPE html>
<html>
<title>URL shortener</title>
<meta name="robots" content="noindex, nofollow">
</html>
<body>
<form method="post" action="shorten.php" id="shortener">
<label for="longurl">URL to shorten</label> <input type="text" name="long_url" id="long_url"> <input type="submit" value="Shorten">
</form>
</form>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script>
$(function () {
    //1111
	$('#shortener').submit(function () {
		$.ajax({data: {long_url: $('#long_url').val()}, url: 'shorten.php', complete: function (XMLHttpRequest, textStatus) {
			$('#long_url').val(XMLHttpRequest.responseText);
		}});
		return false;
	});
});
</script>
</body>
</html>
