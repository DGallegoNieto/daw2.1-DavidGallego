<html>
<head>
    <title>Ejercicio 8 - Calculadora a</title>
</head>
<body>
<h1>Calculadora</h1>
<form action="EJ8bCalculadora.php" method="get">
    <input type="number" name="operando1" placeholder="Operando 1"/>
    <br>
    <br>
    <input type="number" name="operando2" placeholder="Operando 2"/>
    <select name="operacion">
        <option value="sum">Suma</option>
        <option value="res">Resta</option>
        <option value="mult">Multiplicación</option>
        <option value="div">División</option>
    </select>
    <input type="submit" name="calcular" value="Calcular">
</form>
</body>
</html>