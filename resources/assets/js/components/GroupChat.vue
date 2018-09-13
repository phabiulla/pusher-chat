<template>
    <div>
    <div class="panel panel-default">
            <div class="panel-heading" id="accordion">
                <span class="glyphicon glyphicon-comment"></span> {{ window_name }}
                <!--<div class="btn-group pull-right">-->
                    <!--<a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion-" :href="'#collapseOne-' + group.id">-->
                        <!--<span class="glyphicon glyphicon-chevron-down"></span>-->
                    <!--</a>-->
                <!--</div>-->
            </div>
            <div class="panel-collapse collapse in">
                <div class="panel-body chat-panel" style="height: calc(100vh - 120px);">
                    <ul class="chat">
                        <li v-for="conversation in conversations">
                            <span class="chat-img pull-left">
                                <img src="http://placehold.it/50/55C1E7/fff&text=R" alt="User Avatar" class="img-circle" style="padding: 0 6px 0 6px;" />
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">teste</strong>
                                </div>
                                <p>
                                    {{ conversation.message }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." v-model="message" @keyup.enter="store()" autofocus />
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-sm" id="btn-chat" @click.prevent="store()">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['group', 'individual'],

        data() {
            return {
                conversations: [],
                message: '',
                group_id: this.group.id,
                window_name: this.group ? this.group.name : this.individual.name
            }
        },

        mounted() {
            this.listenForNewMessageGroup();

            Bus.$on("conversationChange", (group, user) => {
                this.group = group;
                this.window_name = group ? group.name : user.name
                this.getHistoric();
            });
        },

        methods: {
            getHistoric(element) {
                axios.get('/conversations-group/'+element.id, {id:element.id})
                    .then((response) => {
                        this.conversations = [];
                        this.conversations = response.data;
                    });
            },

            store() {
                axios.post('/conversations-group', {message: this.message, group_id: this.group.id})
                .then((response) => {
                    this.message = '';
                    this.conversations.push(response.data);
                });
            },

            listenForNewMessageGroup() {
                if(this.group) {
                    Echo.private('groups.' + this.group.id)
                        .listen('NewMessageGroup', (e) => {
                            // console.log(e);
                            this.conversations.push(e);
                        });
                }
            }
        }
    }
</script>
