<?php

namespace Webkul\Admin\DataGrids\Contact;

use Illuminate\Support\Facades\DB;
use Webkul\Contact\Repositories\PersonRepository;
use Webkul\UI\DataGrid\DataGrid;

class OrganizationDataGrid extends DataGrid
{
    /**
     * Person repository instance.
     *
     * @var \Webkul\Contact\Repositories\PersonRepository
     */
    protected $personRepository;

    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct(PersonRepository $personRepository)
    {
        parent::__construct();

        $this->personRepository = $personRepository;
    }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('organizations')
            ->addSelect(
                'organizations.id',
                'organizations.name',
                'organizations.name as name_clone',
                'organizations.vk',
                'organizations.site',
                'organizations.instagram',
                'organizations.avito',
                'organizations.ok',
                'organizations.created_at'
            );

        $this->addFilter('id', 'organizations.id');

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        /*$this->addColumn([
            'index'    => 'id',
            'label'    => trans('admin::app.datagrid.id'),
            'type'     => 'string',
            'sortable' => true,
        ]);*/

        $this->addColumn([
            'index'    => 'name',
            'label'    => 'Организация',
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $route = route('admin.contacts.organizations.edit', $row->id);
                return "<a href='" . $route . "'>" . $row->name . "</a>";
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
            'index'            => 'site',
            'label'            => 'Сайт',
            'type'             => 'string',
            'sortable'         => false,
            'closure'  => function ($row) {
                return "<a href='" . $row->site . "' target='_blank'>" . $row->site . "</a>";
            },
        ]);

        $this->addColumn([
            'index'      => 'persons_count',
            'label'      => 'Контакт',
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'    => function ($row) {
                $personFirst = $this->personRepository->findWhere(['organization_id' => $row->id])->first();
                if (empty($personFirst)) {
                    return '---';
                }

                $route = urldecode(route('admin.contacts.persons.index', ['organization[in]' => $row->name_clone]));

                return "<a href='" . $route . "'>" . $personFirst->name . "</a>";
            },
        ]);

        /*$this->addColumn([
            'index'    => 'created_at',
            'label'    => trans('admin::app.datagrid.created_at'),
            'type'     => 'date_range',
            'sortable' => true,
            'closure'  => function ($row) {
                return core()->formatDate($row->created_at);
            },
        ]);*/
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
            'route'  => 'admin.contacts.organizations.edit',
            'icon'   => 'pencil-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'admin.contacts.organizations.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'user']),
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
            'action' => route('admin.contacts.organizations.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
