package org.minimarket.controller;

import jakarta.transaction.Transactional;
import jakarta.validation.Valid;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;
import org.minimarket.model.Producto;
import java.util.List;

@Path("/productos")
@Produces(MediaType.APPLICATION_JSON)
@Consumes(MediaType.APPLICATION_JSON)
public class ProductoController {

    @GET
    public List<Producto> listar() {
        return Producto.findActivos();
    }

    @POST
    @Transactional
    public Response crear(@Valid Producto producto) {
        producto.persist();
        return Response.status(Response.Status.CREATED).entity(producto).build();
    }

    @PUT
    @Path("/{id}")
    @Transactional
    public Response editar(@PathParam("id") Integer id, @Valid Producto datos) {
        Producto p = Producto.findById(id);
        if (p == null) return Response.status(Response.Status.NOT_FOUND).build();
        
        p.nombre = datos.nombre;
        p.proveedor = datos.proveedor;
        p.fechaVencimiento = datos.fechaVencimiento;
        p.precio = datos.precio;
        p.stock = datos.stock;
        p.persist();
        return Response.ok(p).build();
    }

    @DELETE
    @Path("/{id}")
    @Transactional
    public Response eliminar(@PathParam("id") Integer id) {
        Producto p = Producto.findById(id);
        if (p == null) return Response.status(Response.Status.NOT_FOUND).build();
        p.eliminado = true;
        p.persist();
        return Response.ok().build();
    }
}