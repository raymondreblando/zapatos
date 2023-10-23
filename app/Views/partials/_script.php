<script type="module" src="<?= SYSTEM_URL . 'resources' ?>/js/index.js" defer></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js" defer></script>
  
  <?php if($title === 'Dashboard'): ?>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="module" src="<?= SYSTEM_URL . 'resources' ?>/js/chart.js" defer></script>

  <?php endif ?>
</body>
</html>