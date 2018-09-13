<template>
    <div v-if="window.name">
        <div class="panel panel-default" id="conversation-header">
            <div class="panel-heading" id="accordion" style="background: #f5f5f5;">
                <div class="contact">
                    <div class="wrap">
                        <span v-if="window.status" class="contact-status"
                              v-bind:class="{'online':window.status === 'online', 'busy':window.status === 'busy',
                         'away':window.status === 'away', 'offline':window.status === 'offline'}" ></span>
                        <img v-bind:src="window.image" alt="User Avatar" class="img-circle" />
                        <div class="meta">
                            <p class="name">{{window.name}}</p>
                            <p class="preview">{{window.slogan}}</p>
                        </div>
                    </div>
                </div>
                <!---->
                <!--<div class="contact-profile">-->
                    <!--<img v-bind:src="window.image" alt="User Avatar" />-->
                    <!--{{window.name}}<br>-->
                    <!--{{window.slogan}}-->
                <!--</div>-->
            </div>
            <div class="panel-collapse collapse in">
                <div class="panel-body chat-panel messages" style="height: calc(100vh - 230px);">
                    <ul>
                        <li v-for="conversation in conversations" v-bind:class="[user.id === conversation.user_id ? 'replies' : 'sent']">
                            <img v-bind:src="conversation.user.avatar_url" alt="User Avatar" />
                            <p> {{ conversation.message }} </p>
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
    <div v-else-if="!window.name" style="height: calc(100vh - 100px);">
        <img width="90%" height="80%" style="margin:5% 10%;"
             src="http://consciousbrands.com/wp-content/uploads/2016/07/feature-image.jpg" />
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data: function () {
            return {
                conversations: [],
                message: '',
                group: {},
                individual: {},
                window: {
                    name: "",
                    image: "",
                    slogan: "",
                    status: ""
                }
            }
        },

        mounted() {

            Bus.$on("conversationChange", (group, receiver) => {
                this.changeGroup(group);
                this.changeIndividual(receiver);
                this.window = {
                    name: group ? group.name : receiver.nick,
                    slogan: group ? group.description : receiver.slogan,
                    image: group ? group.banner_url : receiver.avatar_url,
                    status: group ? "" : receiver.status
                };
                this.getHistoric();
            });

            this.listenForNewMessageGroup();
            this.listenForNewMessageIndividual();
            this.listenForUserUpdate();
        },

        methods: {
            updateUser(user){
                if(this.individual) {
                    if(this.individual.id === user.id) {
                       this.window.status = user.status;
                    }
                }
            },

            changeGroup(group) {
              this.group = group;
            },

            changeIndividual(individual) {
                this.individual = individual;
            },

            getHistoric() {
                let vm = this;
                if(this.individual){
                    axios.get('/conversations-individual/'+this.individual.id, {id:this.individual.id})
                        .then((response) => {
                            vm.conversations = [];
                            vm.conversations = response.data;
                        });
                } else {
                    axios.get('/conversations-group/'+this.group.id, {id:this.group.id})
                        .then((response) => {
                            vm.conversations = [];
                            vm.conversations = response.data;
                        });
                }
            },

            store() {
                if(this.individual){
                    axios.post('/conversations-individual', {message: this.message, receiver_id: this.individual.id})
                        .then((response) => {
                            this.message = '';
                            this.conversations.push(response.data);
                        });
                } else {
                    axios.post('/conversations-group', {message: this.message, group_id: this.group.id})
                        .then((response) => {
                            this.message = '';
                            this.conversations.push(response.data);
                        });
                }
            },

            listenForNewMessageGroup() {
                if(this.group) {
                    Echo.private('groups.' + this.group.id)
                        .listen('NewMessageGroup', (e) => {
                            this.conversations.push(e);
                        });
                }
            },

            listenForNewMessageIndividual() {
                Echo.private('individual.' + this.user.id)
                    .listen('NewMessageIndividual', (e) => {
                        if(this.individual) {
                            if (this.individual.id === e.user.id) {
                                this.conversations.push(e);
                            }
                        }
                    });
            },

            listenForUserUpdate() {
                Echo.private('updated')
                    .listen('UserUpdated', (e) => {
                        console.log("listen conversation");
                        this.updateUser(e.user)
                    });
            }
        }
    }
</script>
