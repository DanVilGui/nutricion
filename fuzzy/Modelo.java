/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fuzzy;

/**
 *
 * @author Dante
 */
public class Modelo {
    
    public String nombre ;
    public Modelo(String nombre){
        this.nombre = nombre;
    }
    public double [] valores;
    
    public double funcion(double x){
        return 0;
    }
    
    public boolean pertenece(double x){
        if(x<valores[0] || x> valores[valores.length-1] ) return false;
        return true;
    }
     
}
