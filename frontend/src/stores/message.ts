import { defineStore } from "pinia"
import axios from '@/plugins/axios'
import type MessageType from '@/types/MessageType'
import type CreateMessageType from "@/types/CreateMessageTypes"
import type ApiResponseType from "@/types/ApiResponseType"
import type UserType from '@/types/UserType'

export const useMessageStore = defineStore('message', {
    state: () => ({
        message: [] as MessageType[]
    }),
    actions: {
        async fetchData() {
            try {
                const response = await axios.get<ApiResponseType>('message')
                const {data} = response.data
                this.message = data
            } catch (error) {
                console.error('Error fetching data: ', error)
            }
        },

        async createMessage(data: CreateMessageType){
            try {
                const user = await axios.post<UserType>('user', {
                    "name" : data.name,
                    "email" : data.email
                })
                const message = await axios.post('message', {
                    "user_id" : user.data.id,
                    "message" : data.message
                })
            } catch (error) {
                console.error(error)
            }
        }
    }
})