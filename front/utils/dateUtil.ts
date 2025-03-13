import moment from "moment";

export const formattedDate = (date: string | Date, format: string = 'DD/MM/YYYYY') =>
    moment(date).format(format)