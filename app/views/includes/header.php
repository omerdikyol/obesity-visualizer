<!DOCTYPE html>
<html lang="en">
<style>
header {
    position: sticky;
    top: 0;
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
}

/* buttons */
.buttonHeader {
    display: inline-block;
    outline: 0;
    border: 0;
    cursor: pointer;
    transition: box-shadow 0.15s ease,
        transform 0.15s ease;
    will-change: box-shadow,
        transform;
    background: #FCFCFD;
    box-shadow: 0px 2px 4px rgb(45 35 66 / 40%),
        0px 7px 13px -3px rgb(45 35 66 / 30%),
        inset 0px -3px 0px #d6d6e7;
    height: 48px;
    padding: 0 32px;
    font-size: 18px;
    border-radius: 6px;
    color: #36395a;
    transition: box-shadow 0.15s ease,
        transform 0.15s ease;
}

.buttonHeader:hover {
    box-shadow: 0px 4px 8px rgb(45 35 66 / 40%), 0px 7px 13px -3px rgb(45 35 66 / 30%), inset 0px -3px 0px #d6d6e7;
    transform: translateY(-2px);
}
</style>

<body>
    <header>
        <h1>Obesity Visualizer</h1>
        <nav>
            <a href="../../../obesity-visualizer/index.php"><button class="buttonHeader">Home</button></a>
            <a href="../../../obesity-visualizer/app/views/visualize.php"><button
                    class="buttonHeader">Visualize</button></a>
            <a href="../../../obesity-visualizer/app/views/personal.php"><button
                    class="buttonHeader">Personal</button></a>
            <a href="../../../obesity-visualizer/app/views/login.php"><button class="buttonHeader">Login</button></a>
            <a href="../../../obesity-visualizer/app/views/register.php"><button
                    class="buttonHeader">Register</button></a>
            <div style="clear: both;"></div>
    </header>
</body>

</html>