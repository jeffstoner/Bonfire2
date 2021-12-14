<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bonfire\Widgets\Controllers;

use App\Controllers\AdminController;

class WidgetsSettingsController extends AdminController
{
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Bonfire\Modules\Widgets\Views\\';

    /**
     * Display the Widgets settings page.
     */
    public function index(): string
    {
        return $this->render($this->viewPrefix . 'settings', [
            'widgets' => setting('LineChart.widgets'),
        ]);
    }

    /**
     * Saves the Widgets settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     */
    public function save(): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->saveLineSettings();
        $this->saveBarSettings();
        $this->saveDoughnutSettings();
        $this->savePieSettings();
        $this->savePolarAreaSettings();

        alert('success', 'The settings have been saved.');

        return redirect()->route('widgets-settings');
    }

    /**
     * Return the image with preview scheme colors.
     */
    public function getColorSchemePreview(): string
    {
        if (file_exists(ROOTPATH . 'themes/Admin/img/color_scheme/' . $this->request->getVar('bar_colorScheme') . '.png')) {
            //return '<img src="/assets/admin/img/color_scheme/' . $this->request->getVar('bar_colorScheme') . '.png" style="height:40px !important; width:-webkit-fill-available; ';
            return '<img src="/assets/admin/img/color_scheme/' . $this->request->getVar('bar_colorScheme') . '.png" style="height:40px !important; width:300px; ';
        }

        return '';
    }

    /**
     * Saves the Chart Line settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     *
     * @return void
     */
    private function saveLineSettings()
    {
        setting('LineChart.line_showTitle', $this->request->getPost('line_showTitle') ?? false);
        setting('LineChart.line_showSubTitle', $this->request->getPost('line_showSubTitle') ?? false);
        setting('LineChart.line_showLegend', $this->request->getPost('line_showLegend') ?? false);
        setting('LineChart.line_legendPosition', $this->request->getPost('line_legendPosition') ?? false);
        setting('LineChart.line_enableAnimation', $this->request->getPost('line_enableAnimation') ?? false);
        setting('LineChart.line_usePermission', $this->request->getPost('line_usePermission') ?? false);
        setting('LineChart.line_tension', $this->request->getPost('line_tension'));
        setting('LineChart.useCustomSettings', $this->request->getPost('useCustomSettings') ?? false);

        if (setting('LineChart.useCustomSettings')) {
            setting('LineChart.line_borderColor', $this->request->getPost('line_borderColor') ?? '#000000');
            setting('LineChart.line_borderWidth', $this->request->getPost('line_borderWidth') ?? 1);
            setting('LineChart.line_pointBackgroundColor', $this->request->getPost('line_pointBackgroundColor'));
            setting('LineChart.line_pointBorderColor', $this->request->getPost('line_pointBorderColor'));
            setting('LineChart.line_pointBorderWidth', $this->request->getPost('line_pointBorderWidth'));
        } else {
            setting()->forget('LineChart.line_borderColor');
            setting()->forget('LineChart.line_borderWidth');
            setting()->forget('LineChart.line_pointBackgroundColor');
            setting()->forget('LineChart.line_pointBorderColor');
            setting()->forget('LineChart.line_pointBorderWidth');
        }
    }

    /**
     * Saves the Chart Bar settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     *
     * @return void
     */
    private function saveBarSettings()
    {
        setting('BarChart.bar_showTitle', $this->request->getPost('bar_showTitle') ?? false);
        setting('BarChart.bar_showLegend', $this->request->getPost('bar_showLegend') ?? false);
        setting('BarChart.bar_legendPosition', $this->request->getPost('bar_legendPosition') ?? false);
        setting('BarChart.bar_enableAnimation', $this->request->getPost('bar_enableAnimation') ?? false);
        setting('BarChart.bar_colorScheme', $this->request->getPost('bar_colorScheme') ?? 'null');
    }

    /**
     * Saves the Chart Doughnut settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     *
     * @return void
     */
    private function saveDoughnutSettings()
    {
        setting('DoughnutChart.doughnut_showTitle', $this->request->getPost('doughnut_showTitle') ?? false);
        setting('DoughnutChart.doughnut_showLegend', $this->request->getPost('doughnut_showLegend') ?? false);
        setting('DoughnutChart.doughnut_legendPosition', $this->request->getPost('doughnut_legendPosition') ?? false);
        setting('DoughnutChart.doughnut_enableAnimation', $this->request->getPost('doughnut_enableAnimation') ?? false);
        setting('DoughnutChart.doughnut_colorScheme', $this->request->getPost('doughnut_colorScheme') ?? 'null');
    }

    /**
     * Saves the Chart Pie settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     *
     * @return void
     */
    private function savePieSettings()
    {
        setting('PieChart.pie_showTitle', $this->request->getPost('pie_showTitle') ?? false);
        setting('PieChart.pie_showLegend', $this->request->getPost('pie_showLegend') ?? false);
        setting('PieChart.pie_legendPosition', $this->request->getPost('pie_legendPosition') ?? false);
        setting('PieChart.pie_enableAnimation', $this->request->getPost('pie_enableAnimation') ?? false);
        setting('PieChart.pie_colorScheme', $this->request->getPost('pie_colorScheme') ?? 'null');
    }

    /**
     * Saves the Chart Pola Area settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     *
     * @return void
     */
    private function savePolarAreaSettings()
    {
        setting('PolarAreaChart.polarArea_showTitle', $this->request->getPost('polarArea_showTitle') ?? false);
        setting('PolarAreaChart.polarArea_showLegend', $this->request->getPost('polarArea_showLegend') ?? false);
        setting('PolarAreaChart.polarArea_legendPosition', $this->request->getPost('polarArea_legendPosition') ?? false);
        setting('PolarAreaChart.polarArea_enableAnimation', $this->request->getPost('polarArea_enableAnimation') ?? false);
        setting('PolarAreaChart.polarArea_colorScheme', $this->request->getPost('polarArea_colorScheme') ?? 'null');
    }

    /**
     * Reset all the widget settings to their default values
     */
    public function resetSettings(): \CodeIgniter\HTTP\RedirectResponse
    {
        setting()->forget('LineChart.line_showTitle');
        setting()->forget('LineChart.line_showSubTitle');
        setting()->forget('LineChart.line_showLegend');
        setting()->forget('LineChart.line_legendPosition');
        setting()->forget('LineChart.line_enableAnimation');
        setting()->forget('LineChart.line_usePermission');
        setting()->forget('LineChart.line_tension');
        setting()->forget('LineChart.useCustomSettings');
        setting()->forget('LineChart.line_borderColor');
        setting()->forget('LineChart.line_borderWidth');
        setting()->forget('LineChart.line_pointBackgroundColor');
        setting()->forget('LineChart.line_pointBorderColor');
        setting()->forget('LineChart.line_pointBorderWidth');

        setting()->forget('BarChart.bar_showTitle');
        setting()->forget('BarChart.bar_showLegend');
        setting()->forget('BarChart.bar_legendPosition');
        setting()->forget('BarChart.bar_enableAnimation');
        setting()->forget('BarChart.bar_colorScheme');

        setting()->forget('DoughnutChart.doughnut_showTitle');
        setting()->forget('DoughnutChart.doughnut_showLegend');
        setting()->forget('DoughnutChart.doughnut_legendPosition');
        setting()->forget('DoughnutChart.doughnut_enableAnimation');
        setting()->forget('DoughnutChart.doughnut_colorScheme');

        setting()->forget('PieChart.pie_showTitle');
        setting()->forget('PieChart.pie_showLegend');
        setting()->forget('PieChart.pie_legendPosition');
        setting()->forget('PieChart.pie_enableAnimation');
        setting()->forget('PieChart.pie_colorScheme');

        setting()->forget('PolarAreaChart.polarArea_showTitle');
        setting()->forget('PolarAreaChart.polarArea_showLegend');
        setting()->forget('PolarAreaChart.polarArea_legendPosition');
        setting()->forget('PolarAreaChart.polarArea_enableAnimation');
        setting()->forget('PolarAreaChart.polarArea_colorScheme');

        alert('success', 'The settings have been reset.');

        return redirect()->route('widgets-settings');
    }
}
