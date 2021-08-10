<?php

declare(strict_types=1);

namespace App\Commands\Sites\Reports;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\Reports\PageViewRequest;
use Illuminate\Console\Command;

class PageViewReportCommand extends FathomCommand
{
    protected $signature = 'reports:page-views
                            {id : The fathom site ID}
                            {--sum=* : Aggregate against; visits,uniques,pageviews,avg_durations,bounce_rate}
                            {--grouping=* : Group field by; hostname,pathname,referrer_hostname,referrer_pathname,browser,country,device_typeutm_campaign,utm_content,utm_medium,utm_source,utm_term,keyword,q,ref,s}
                            {--timezone= : Optionally add the datetime output in your local time eg: Europe/London}
                            {--from= : Set the date range from}
                            {--to= : Set the date range to}';

    protected $description = 'Fetch the page view report for a site.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        $response = PageViewRequest::build()
            ->authenticate()
            ->withQuery(
                query: [
                    'entity' => 'pageview',
                    'entity_id' => $this->argument('id'),
                    'aggregates' => implode(',', $this->option('sum')),
                    'field_grouping' => implode(',', $this->option('grouping')),
                    'timezone' => $this->option('timezone') ?? 'UTC',
                ],
            )->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        dd($response->json());

        return Command::SUCCESS;
    }
}
