import type UserType from '@/types/UserType'

export default interface ApiUserResponse {
    data: UserType[]
    id?: number
}