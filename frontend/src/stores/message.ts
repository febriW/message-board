import { defineStore } from "pinia"
import axios from '@/plugins/axios'
import type MessageType from '@/types/MessageType'
import type CreateMessageType from "@/types/CreateMessageTypes"
import type ApiMessageResponseType from "@/types/ApiMessageResponseType"
import type SearchMessageType from "@/types/SearchMessageType"
import type ApiUserResponse from "@/types/ApiUserResponseType"

export const useMessageStore = defineStore('message', {
    state: () => ({
        message: [] as MessageType[]
    }),
    actions: {
        async fetchData() {
            try {
                const response = await axios.get<ApiMessageResponseType>('message')
                const {data} = response.data
                this.message = data
            } catch (error) {
                console.error('Error fetching data: ', error)
            }
        },

        async createMessage(params: CreateMessageType){
            try {
                const response = await axios.post<ApiUserResponse>('user', {
                    "name" : params.name,
                    "email" : params.email
                }).then((response) => {
                    axios.post<ApiMessageResponseType>('message', {
                        "user_id" : response.data.id,
                        "message" : params.message 
                    })
                })
            } catch (error) {
                console.error(error)
            }
        },

        async searchMessage(params: SearchMessageType){
            try {
                const response = await axios.post<ApiMessageResponseType>('message/search', {
                    "params" : params.params,
                    "page": params.pages
                })
                const {data} = response.data
                this.message.push(...data)
            } catch (error) {
                console.error(error)
            }
        }
    }
})