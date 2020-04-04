<v-navigation-drawer
        class="my-nav"
        v-cloak
        fixed
        :width="($vuetify.breakpoint.smAndDown)? '90vw' : '25vw'"
        temporary
        v-model="menu"
        color="primary"
        dark
        style="border-top-right-radius: 16px; border-bottom-right-radius: 16px; "
>
    <v-list
            v-if="menu"
            dark
            class="nav"
    >
        <v-list-item>
            <div class="my-header">
                <h3>Menu strony</h3>
            </div>
        </v-list-item>
        {{menu('main', 'vendor.voyager.menus.vuetify')}}
        <v-divider></v-divider>

    </v-list>
</v-navigation-drawer>