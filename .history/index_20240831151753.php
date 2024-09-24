<?php
include 'conn.php';

// Fetch active sliders from the database
$sql = "SELECT * FROM sliders WHERE is_active = 1";
$result = $conn->query($sql);
?>

<section>
    <div class="slider-1">
        <div class="rev_slider" id="js-slider" style="display:none;">
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                <li class="item-1 <?php echo $row['class']; ?>" data-transition="crossfade">
                    <img class="rev-slidebg" src="<?php echo $row['image']; ?>" alt="#" />
                    <h3 class="tp-caption tp-resizeme caption-1" data-frames="<?php echo $row['caption1_frames']; ?>"
                        data-x="['center']" data-hoffset="['0']" data-y="['middle']" data-voffset="['-100']"
                        data-width="['1000']"><?php echo $row['caption1']; ?></h3>
                    <div class="tp-caption tp-resizeme caption-2" data-frames="<?php echo $row['caption2_frames']; ?>"
                        data-x="['center']" data-hoffset="['0']" data-y="['middle']" data-voffset="['-10']"
                        data-width="['800']"><?php echo $row['caption2']; ?></div>
                    <!-- Uncomment if you have buttons -->
                    <!-- <button class="tp-caption tp-resizeme au-btn au-btn-primary au-btn-radius"
                        data-frames="<?php echo $row['button_frames']; ?>"
                        data-x="['center']" data-hoffset="['0']" data-y="['middle']" data-voffset="['80']">
                        <?php echo $row['button_text']; ?>
                    </button> -->
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</section>

<?php
$conn->close();
?>
