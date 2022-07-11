
<form action="result.challenge.php" method="post">
    お名前：<input type="text" name="my_name" />
    <br>
    ご希望景品：
    <input type="radio" name="keihin" value="A賞">A賞
    <input type="radio" name="keihin" value="B賞">B賞
    <input type="radio" name="keihin" value="C賞">C賞
    <br>
    個数：<select name="number">
            <?php for ($i=1;$i<=10;$i++){ ?>
              <option value="<?php echo $i; ?>">
                <?php echo $i; ?>
              </option>
            <?php } ?>
    </select>
    <br>
    <input type="submit" value="申込" />
    <br>
</form>