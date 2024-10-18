<?php include('views/partials/header.php'); ?>

<h1>Artists</h1>

<p>
    <a href=".?action=artistForm">
        Add Artist
    </a>
</p>

<table>
    <thead>
        <th>Name</td>
        <th>Monthly Listeners</th>
    </thead>
    <tbody>
        <?php foreach ($artists as $artist) : ?>
        <tr>
            <td>
                <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
                    <?php echo htmlspecialchars($artist['name']); ?>
                </a>
            </td>
            <td>
                <?php echo number_format($artist['monthlyListeners'], 0, '.', ','); ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php include('views/partials/footer.php'); ?>
