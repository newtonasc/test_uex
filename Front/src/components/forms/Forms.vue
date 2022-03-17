<template>
    <div class="container-fluid">
        <b-modal :no-close-on-esc="true" :no-close-on-backdrop="true" id="modalFormContact" hide-footer centered size="lg">
            <template #modal-title>
                {{ type == 'edit' ? 'Editar contato' : 'Novo contato' }}
            </template>
            <div class="d-block">
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Nome:" label-for="name">
                            <b-form-input :class="errorFields.name ? 'field-error' : ''" id="name" v-model="form.name" placeholder="Nome" maxlength="150" @keyup="cleanError('name')" required></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="4">
                        <b-form-group label="CPF:" label-for="cpf">
                            <b-form-input :class="errorFields.cpf ? 'field-error' : ''" :disabled="type == 'edit'" id="cpf" v-model="form.cpf" placeholder="CPF" v-mask="'###.###.###-##'" @keyup="cleanError('cpf')" required></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="4">
                        <b-form-group label="Celular:" label-for="phone">
                            <b-form-input :class="errorFields.phone ? 'field-error' : ''" id="phone" v-model="form.phone" placeholder="Celular" v-mask="'(##) #####-####'" @keyup="cleanError('phone')" required></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="4">
                        <b-form-group label="Tipo:" label-for="type">
                            <b-form-select :class="errorFields.type ? 'field-error' : ''" id="type" v-model="form.type_id" :options="listContactTypes" :disabled="loadingContactTypeList" @keyup="cleanError('type_id')"></b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-group label="Endereço:" label-for="address">
                            <b-form-input :class="errorFields.address ? 'field-error' : ''" id="address" v-model="form.address" placeholder="Endereço" maxlength="150" @change="changedAddress" @keyup="cleanError('address')" required></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="9">
                        <b-form-group label="Bairro:" label-for="neighborhood">
                            <b-form-input :disabled="true" id="neighborhood" v-model="form.neighborhood" placeholder="Bairro" required></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="3">
                        <b-form-group label="Número:" label-for="number">
                            <b-form-input :disabled="true" id="number" v-model="form.number" placeholder="Número" required></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                 <b-row>
                     <b-col cols="5">
                        <b-form-group label="Cidade:" label-for="city">
                            <b-form-input :disabled="true" id="city" v-model="form.city" placeholder="Cidade" required></b-form-input>
                        </b-form-group>
                    </b-col>    
                    <b-col cols="5">
                        <b-form-group label="Estado:" label-for="state">
                            <b-form-input :disabled="true" id="state" v-model="form.state" placeholder="Estado" required></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="2">
                        <b-form-group label="CEP:" label-for="cep">
                            <b-form-input :disabled="true" id="cep" v-model="form.cep" placeholder="CEP" required v-mask="'#####-###'"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
            </div>
            <div class="content-buttons text-right">
                <b-button variant="link" size="sm" @click="close">Cancelar</b-button>
                <b-button variant="info" size="sm" @click="save">Salvar</b-button>
            </div>
        </b-modal>        
    </div>
</template>
<script src="./Forms.js"></script>
<style scoped src="./Forms.css"></style>
<style lang="css">
    .pac-container {
        z-index: 4000 !important;        
    }
    .pac-container:after{
            display:none !important;
    }
    .pac-icon {
        display: none;
    }
    .pac-item {
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
    }
    .pac-item:hover {
        background-color: var(--gray-4); 
    }
    .pac-item-query {
        font-size: 16px;
    }
</style>
