import http from "../http-common"

class DataService {
    constructor(endpoint) {
        this.endpoint = endpoint;
    }

    getAll(offset = 0, limit = 12) {
        return http.get(`/${this.endpoint}`, {
            'headers': {
                'offset': offset,
                'limit': limit
            }
        });
    }
    get(id) {
        return http.get(`/${this.endpoint}/${id}`);
    }
    create(data) {
        return http.post(`/${this.endpoint}`, data);
    }
    update(id, data) {
        return http.put(`/${this.endpoint}/${id}`, data);
    }
    delete(id) {
        return http.delete(`/${this.endpoint}/${id}`);
    }
}

export default DataService;
