<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * handle row specific actions like edit, delete, export
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

use PhpMyAdmin\Response;
use PhpMyAdmin\Sql;
use PhpMyAdmin\Url;

if (! defined('PHPMYADMIN')) {
    exit;
}

global $containerBuilder, $db, $goto, $pmaThemeImage, $sql_query, $table;
global $submit_mult, $active_page, $err_url, $original_sql_query, $url_query, $original_url_query;
global $disp_message, $disp_query, $single_table, $where_clause;

if (isset($_POST['submit_mult'])) {
    $submit_mult = $_POST['submit_mult'];
    // workaround for IE problem:
} elseif (isset($_POST['submit_mult_delete_x'])) {
    $submit_mult = 'row_delete';
} elseif (isset($_POST['submit_mult_change_x'])) {
    $submit_mult = 'row_edit';
} elseif (isset($_POST['submit_mult_export_x'])) {
    $submit_mult = 'row_export';
}

// If the 'Ask for confirmation' button was pressed, this can only come
// from 'delete' mode, so we set it straight away.
if (isset($_POST['mult_btn'])) {
    $submit_mult = 'row_delete';
}

if (! isset($submit_mult)) {
    $submit_mult = 'row_edit';
}

switch ($submit_mult) {
    case 'row_delete':
    case 'row_edit':
    case 'row_copy':
    case 'row_export':
        // leave as is
        break;

    case 'export':
        $submit_mult = 'row_export';
        break;

    case 'delete':
        $submit_mult = 'row_delete';
        break;

    case 'copy':
        $submit_mult = 'row_copy';
        break;

    case 'edit':
    default:
        $submit_mult = 'row_edit';
        break;
}

if (! empty($submit_mult)) {
    if (isset($_POST['goto'])
        && (! isset($_POST['rows_to_delete'])
        || ! is_array($_POST['rows_to_delete']))
    ) {
        $response = Response::getInstance();
        $response->setRequestStatus(false);
        $response->addJSON('message', __('No row selected.'));
    }

    switch ($submit_mult) {
    /** @noinspection PhpMissingBreakStatementInspection */
        case 'row_copy':
            $_POST['default_action'] = 'insert';
            // no break to allow for fallthough
        case 'row_edit':
            // As we got the rows to be edited from the
            // 'rows_to_delete' checkbox, we use the index of it as the
            // indicating WHERE clause. Then we build the array which is used
            // for the /table/change script.
            $where_clause = [];
            if (isset($_POST['rows_to_delete'])
            && is_array($_POST['rows_to_delete'])
            ) {
                foreach ($_POST['rows_to_delete'] as $i => $i_where_clause) {
                    $where_clause[] = $i_where_clause;
                }
            }
            $active_page = Url::getFromRoute('/table/change');
            include ROOT_PATH . 'libraries/entry_points/table/change.php';
            break;

        case 'row_export':
            // Needed to allow SQL export
            $single_table = true;

            // As we got the rows to be exported from the
            // 'rows_to_delete' checkbox, we use the index of it as the
            // indicating WHERE clause. Then we build the array which is used
            // for the /table/change script.
            $where_clause = [];
            if (isset($_POST['rows_to_delete'])
            && is_array($_POST['rows_to_delete'])
            ) {
                foreach ($_POST['rows_to_delete'] as $i => $i_where_clause) {
                    $where_clause[] = $i_where_clause;
                }
            }
            $active_page = Url::getFromRoute('/table/export');
            include ROOT_PATH . 'libraries/entry_points/table/export.php';
            break;

        case 'row_delete':
        default:
            $action = Url::getFromRoute('/table/row_action');
            $err_url = Url::getFromRoute('/table/row_action', $GLOBALS['url_params']);
            if (! isset($_POST['mult_btn'])) {
                $original_sql_query = $sql_query;
                if (! empty($url_query)) {
                    $original_url_query = $url_query;
                }
            }
            include ROOT_PATH . 'libraries/mult_submits.inc.php';
            $_url_params = $GLOBALS['url_params'];
            $_url_params['goto'] = Url::getFromRoute('/table/sql');
            $url_query = Url::getCommon($_url_params);

            /**
         * Show result of multi submit operation
         */
            // sql_query is not set when user does not confirm multi-delete
            if ((! empty($submit_mult) || isset($_POST['mult_btn']))
            && ! empty($sql_query)
            ) {
                $disp_message = __('Your SQL query has been executed successfully.');
                $disp_query = $sql_query;
            }

            if (isset($original_sql_query)) {
                $sql_query = $original_sql_query;
            }

            if (isset($original_url_query)) {
                $url_query = $original_url_query;
            }

            $active_page = Url::getFromRoute('/sql');
            $sql = new Sql();
            $sql->executeQueryAndSendQueryResponse(
                null, // analyzed_sql_results
                false, // is_gotofile
                $db, // db
                $table, // table
                null, // find_real_end
                null, // sql_query_for_bookmark
                null, // extra_data
                null, // message_to_show
                null, // message
                null, // sql_data
                $goto, // goto
                $pmaThemeImage, // pmaThemeImage
                null, // disp_query
                null, // disp_message
                null, // query_type
                $sql_query, // sql_query
                null, // selectedTables
                null // complete_query
            );
    }
}
