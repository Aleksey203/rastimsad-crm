@push('scripts')
    <script type="text/x-template" id="contact-component-template">

        <div class="form-group text" :class="[errors.has('{!! $formScope ?? '' !!}person[name]') ? 'has-error' : '']">
            <label for="person[name]" class="required">Контакт</label>

            <input
                type="text"
                name="person[name]"
                class="control"
                id="person[name]"
                v-model="person.name"
                autocomplete="off"
                placeholder="Вводите имя для старта поиска"
                v-validate="'required'"
                data-vv-as="&quot;{{ __('admin::app.leads.name') }}&quot;"
                v-on:keyup="search"
            />

            <input
                type="hidden"
                name="person[id]"
                v-model="person.id"
                v-validate="'required'"
                data-vv-as="&quot;{{ __('admin::app.leads.name') }}&quot;"
                v-if="person.id"
            />

            <div class="lookup-results" v-if="state == ''">
                <ul>
                    <li v-for='(person, index) in persons' @click="addPerson(person)">
                        <span>@{{ person.name }}</span>
                    </li>

                    <li v-if="! persons.length && person['name'].length && ! is_searching">
                        <span>{{ __('admin::app.common.no-result-found') }}</span>
                    </li>

                    {{--<li class="action" v-if="person['name'].length && ! is_searching" @click="addAsNew()">
                        <span>
                            + {{ __('admin::app.common.add-as') }}
                        </span>
                    </li>--}}
                </ul>
            </div>

            <span class="control-error" v-if="errors.has('{!! $formScope ?? '' !!}person[name]')">
                @{{ errors.first('{!! $formScope ?? '' !!}person[name]') }}
            </span>
        </div>

    </script>

    <script>
        Vue.component('contact-component', {

            template: '#contact-component-template',

            props: ['data'],

            inject: ['$validator'],

            data: function () {
                return {
                    is_searching: false,

                    state: this.data ? 'old': '',

                    person: this.data ? this.data : {
                        'name': ''
                    },

                    persons: [],
                }
            },

            methods: {
                search: debounce(function () {
                    this.state = '';

                    this.person = {
                        'name': this.person['name']
                    };

                    this.is_searching = true;

                    if (this.person['name'].length < 2) {
                        this.persons = [];

                        this.is_searching = false;

                        return;
                    }

                    var self = this;

                    this.$http.get("{{ route('admin.contacts.persons.search') }}", {params: {query: this.person['name']}})
                        .then (function(response) {
                            self.persons = response.data;

                            self.is_searching = false;
                        })
                        .catch (function (error) {
                            self.is_searching = false;
                        })
                }, 500),

                addPerson: function(result) {
                    this.state = 'old';

                    this.person = result;
                },

                addAsNew: function() {
                    this.state = 'new';
                }
            }
        });
    </script>
@endpush
