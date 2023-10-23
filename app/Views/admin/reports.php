<?php

  require_once __DIR__.'/../../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  if (Utilities::isCustomer()) {
    Utilities::redirectAuthorize('shoes/');
  }
  
  $title = isset($type) ? ucwords(str_replace('-', ' ', $type)) : 'Reports';

  require_once 'app/Views/partials/_header.php';
  require_once 'app/Views/partials/_loader.php';
  require_once 'app/Views/partials/_toast.php';

  $reportParams = $title === 'Reports' ? '' : $title;
  $reports = $reportController->show($reportParams);
  
?>

  <main class="main-wrapper">

    <?php require_once 'app/Views/partials/_sidebar.php' ?>

    <section class="main__section">

      <?php require_once 'app/Views/partials/_topnav.php' ?>

      <div class="main__content">
        <div class="main__content-header">
          <div>
            <h1 class="main__content-heading">Reports</h1>
            <p class="main__content-subheading">Manage and generate reports.</p>
          </div>

          <form id="generate-form">
            <div class="select-group report-input-group">
              <div class="custom-select">
                <select name="type">
                  <option value="">Report Type</option>
                  <option value="Inventory">Inventory</option>
                  <option value="Sales">Sales</option>
                </select>
              </div>
  
              <div class="custom-date">
                <input type="date" name="start_date" class="report-date-start">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/calendar.svg" alt="calendar">
              </div>
              <div class="custom-date">
                <input type="date" name="end_date" class="report-date-end">
                <img src="<?= SYSTEM_URL . 'public' ?>/icons/calendar.svg" alt="calendar">
              </div>
  
              <button type="submit" id="generate-btn" class="main__create">
                <div class="spinner"></div>
                Generate
              </button>
            </div>
          </form>
        </div>

        <div class="main__filter-wrapper">
          <div class="main__tabs">
            <a href="<?= SYSTEM_URL . 'reports/' ?>"class="<?= Utilities::setDynamicClassname($title, ['Reports']) ?>">All</a>
            <a href="<?= SYSTEM_URL . 'reports/sales' ?>" class="<?= Utilities::setDynamicClassname($title, ['Sales']) ?>">Sales</a>
            <a href="<?= SYSTEM_URL . 'reports/inventory' ?>" class="<?= Utilities::setDynamicClassname($title, ['Inventory']) ?>">Inventory</a>
          </div>

          <div class="input-group">
            <div class="custom-date">
              <input type="date" id="date-filter" class="date-start">
              <img src="<?= SYSTEM_URL . 'public' ?>/icons/calendar.svg" alt="calendar">
            </div>
          </div>
        </div>

        <div class="main__grid-cols-4">

          <?php  
            $reportPlaceholderCount = 20;
            $totalReportCount = count($reports);
            $maxReportCount = $totalReportCount > $reportPlaceholderCount ? $totalReportCount : $reportPlaceholderCount;

            for ($reportIndex = 0; $reportIndex < $maxReportCount; $reportIndex++) :
              if (isset($reports[$reportIndex])) : 
                $reportType = $reports[$reportIndex]->report_type;
                $reportStartDate = Utilities::formatDate($reports[$reportIndex]->report_start_date, 'M d');
                $reportEndDate = Utilities::formatDate($reports[$reportIndex]->report_end_date, 'M d, Y');
                $reportStartDateSqlFormat = Utilities::formatDate($reports[$reportIndex]->report_start_date, 'Y-m-d');
                $reportEndDateSqlFormat = Utilities::formatDate($reports[$reportIndex]->report_end_date, 'Y-m-d');
                $filename = $reportStartDate . '-' . $reportEndDate . ' ' . $reportType;
          ?>

                <div class="search-area">
                  <div class="report-card">
                    <div class="report-card__details">
                      <div class="report-card__icon">
                        <img src="<?= SYSTEM_URL . 'public' ?>/icons/report-white.svg" alt="report">
                      </div>
                      <div>
                        <p class="finder1 report-card__type"><?= $reportType ?> Report</p>
                        <p class="report-card__date"><?= $reportStartDate . '-' . $reportEndDate ?></p>
                        <p class="finder2" hidden><?= $reportStartDateSqlFormat . ' ' . $reportEndDateSqlFormat ?></p>
                      </div>
                    </div>
  
                    <div class="report-card__actions">
                      <button type="button" class="report-card__button button--print" title="Print" data-value="<?= $reports[$reportIndex]->report_id ?>">
                        <img src="<?= SYSTEM_URL . 'public' ?>/icons/print.svg" alt="print">
                      </button>
                      <button type="button" class="report-card__button button--download" title="Download" data-value="<?= $reports[$reportIndex]->report_id ?>" data-date="<?= $filename ?>">
                        <img src="<?= SYSTEM_URL . 'public' ?>/icons/download.svg" alt="download">
                      </button>
                    </div>
                  </div>
                </div>

            <?php 
              else : 
            ?>

                <div class="report-card">
                  <div class="report-card__details">
                    <div class="report-card__icon skeleton">
                    </div>
                    <div>
                      <div style="width: 85px; height: 10px; background-color: #f7f8fa; margin-bottom: 4px; border-radius: 100px;"></div>
                      <div style="width: 35px; height: 8px; background-color: #f7f8fa; border-radius: 100px;"></div>
                    </div>
                  </div>

                  <div class="report-card__actions">
                    <div style="width: 30px; height: 30px; background-color: #f7f8fa; border-radius: 3px;"></div>
                    <div style="width: 30px; height: 30px; background-color: #f7f8fa; border-radius: 3px;"></div>
                  </div>
                </div>

          <?php 
              endif;
            endfor
          ?>
          
        </div>
      </div>
    </section>
  </main>

<?php require_once 'app/Views/partials/_script.php' ?>