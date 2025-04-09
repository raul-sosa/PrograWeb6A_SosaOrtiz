package com.example.programacionweb_its_prac1;

import io.jsonwebtoken.JwtParser;
import io.jsonwebtoken.Jwts;
import jakarta.servlet.http.*;
import jakarta.servlet.annotation.*;

import java.io.IOException;
import java.util.Base64;
import java.util.HashMap;
import java.util.Map;

import static com.example.programacionweb_its_prac1.AutenticacionServlet.generalKey;

@WebServlet("/user-servlet/*")
public class UserServlet extends HttpServlet {
    private final JsonResponse jResp = new JsonResponse();

    private final HashMap<String, User> users = AutenticacionServlet.users;

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws IOException {
        resp.setContentType("application/json");
        String authTokenHeader = req.getHeader("Authorization");
        if (authTokenHeader == null || !authTokenHeader.startsWith("Bearer ")) {
            jResp.failed(req, resp, "Token no proporcionado", HttpServletResponse.SC_UNAUTHORIZED);
            return;
        }

        String token = authTokenHeader.split(" ")[1];
        validateAuthToken(req, resp, token);
    }



    private void validateAuthToken (HttpServletRequest req, HttpServletResponse resp, String token) throws IOException {


        JwtParser jwtParser = Jwts.parser()
                .verifyWith(generalKey())
                .build();
        try {
            String username = jwtParser.parseSignedClaims(token)
                    .getPayload()
                    .getSubject();


            User user = users.get(username);
            if (user == null) {
                jResp.failed(req, resp, "Usuario no encontrado", HttpServletResponse.SC_NOT_FOUND);
                return;
            }


            Map<String, Object> userData = new HashMap<>();
            userData.put("fullName", user.getFullName());
            userData.put("email", user.getEmail());
            userData.put("username", user.getUsername());

            jResp.success(req, resp, "Datos de usuario", userData);

        } catch (Exception e) {
            jResp.failed(req, resp, "Unauthorized: " + e.getMessage(), HttpServletResponse.SC_UNAUTHORIZED);
        }
    }}

