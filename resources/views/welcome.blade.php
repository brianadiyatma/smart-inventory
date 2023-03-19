<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<p id="myPelement"></p>
<table>
    <tbody id="data">
        
    </tbody>
</table>
</body>
<script type="text/javascript">
    const p = document.getElementById("myPelement")
    fetch('http://127.0.0.1:8000/api/posts')
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        p.innerText = data.title+data.content
    });
</script>
</html>
