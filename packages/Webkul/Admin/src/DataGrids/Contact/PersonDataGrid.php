<?php

namespace Webkul\Admin\DataGrids\Contact;

use Illuminate\Support\Facades\DB;
use Webkul\Admin\Traits\ProvideDropdownOptions;
use Webkul\UI\DataGrid\DataGrid;

class PersonDataGrid extends DataGrid
{
    use ProvideDropdownOptions;

    /**
     * Export option.
     *
     * @var boolean
     */
    protected $export;

    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->export = bouncer()->hasPermission('contacts.persons.export') ? true : false;
    }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('persons')
            ->addSelect(
                'persons.id',
                'persons.name as person_name',
                'persons.vk',
                'persons.telegram',
                'persons.contact_numbers',
                'organizations.name as organization',
                'organizations.id as organization_id',
                'organizations.name as organization_name'
            )
            ->leftJoin('organizations', 'persons.organization_id', '=', 'organizations.id');

        $this->addFilter('id', 'persons.id');
        $this->addFilter('person_name', 'persons.name');
        $this->addFilter('organization', 'organizations.name');

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'hidden',
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'    => 'person_name',
            'label'    => 'Имя',
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $route = route('admin.contacts.persons.edit', $row->id);
                return "<a href='" . $route . "'>" . $row->person_name . "</a>";
            },
        ]);

        /*$this->addColumn([
            'index'    => 'emails',
            'label'    => trans('admin::app.datagrid.emails'),
            'type'     => 'string',
            'sortable' => false,
            'closure'  => function ($row) {
                $emails = json_decode($row->emails, true);

                if ($emails) {
                    return collect($emails)->pluck('value')->join(', ');
                }
            },
        ]);*/

        $this->addColumn([
            'index'    => 'contact_numbers',
            'label'    => 'Телефоны',
            'type'     => 'string',
            'sortable' => false,
            'closure'  => function ($row) {
                $contactNumbers = json_decode($row->contact_numbers, true);

                if ($contactNumbers) {
                    return collect($contactNumbers)->pluck('value')->transform(function ($item, $key) {
                        return '<a href="tel:+' . $item . '">+' . $item . '</a>';
                    })->join(' , ');
                }
            },
        ]);

        $this->addColumn([
            'index'            => 'vk',
            'label'            => 'VK',
            'type'             => 'string',
            'sortable'         => false,
            'closure'  => function ($row) {
                return "<a href='" . $row->vk . "' target='_blank'>" . $row->vk . "</a>";
            },
        ]);
        $this->addColumn([
            'index'            => 'telegram',
            'label'            => 'Telegram',
            'type'             => 'string',
            'sortable'         => false,
            'closure'  => function ($row) {
                return "<a href='" . $row->telegram . "' target='_blank'>" . $row->telegram . "</a>";
            },
        ]);
        $this->addColumn([
            'index'            => 'organization',
            'label'            => 'Организация',
            'type'             => 'string',
            //'dropdown_options' => $this->getOrganizationDropdownOptions(),
            'sortable'         => false,
            'closure'  => function ($row) {
                $route = urldecode(route('admin.contacts.organizations.index', ['name[in]' => $row->organization]));
                return "<a href='" . $route . "'>" . $row->organization . "</a>";
            },
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('ui::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'admin.contacts.persons.edit',
            'icon'   => 'pencil-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'admin.contacts.persons.delete',
            'confirm_text' => trans(
                'ui::app.datagrid.massaction.delete',
                ['resource' => trans('admin::app.contacts.persons.person')]
            ),
            'icon'         => 'trash-icon',
        ]);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('ui::app.datagrid.delete'),
            'action' => route('admin.contacts.persons.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
